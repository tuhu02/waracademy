<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TournamentScoringService
{
    /**
     * Hitung skor untuk satu peserta (bisa peserta tim atau solo)
     * Menggunakan formula:
     * base_score = correct * 10
     * accuracy_bonus = (correct/answered) * 20
     * speed_bonus = (remaining_time / total_time) * 20
     *
     * @param int $id_peserta  -- id_peserta dari tabel pesertaturnamen
     * @param int $id_turnamen
     * @return float
     */
    public static function calculateParticipantScore(int $id_peserta, int $id_turnamen): float
    {
        // ambil jumlah answered & correct dari tabel turnamen_jawaban_peserta
        $agg = DB::table('turnamen_jawaban_peserta')
            ->where('id_peserta', $id_peserta)
            ->selectRaw('COUNT(*) as answered, SUM(is_correct) as correct, MAX(answered_at) as last_answered')
            ->first();

        $answered = (int) ($agg->answered ?? 0);
        $correct  = (int) ($agg->correct ?? 0);

        // base score
        $base_score = $correct * 10;

        // accuracy bonus guard division by zero
        $accuracy_bonus = 0.0;
        if ($answered > 0) {
            $accuracy = $correct / $answered;
            $accuracy_bonus = $accuracy * 20;
        }

        // speed bonus
        $turnamen = DB::table('turnamen')->where('id_turnamen', $id_turnamen)->first();
        $remaining_ratio = 0.0;

        if ($turnamen && $turnamen->durasi_pengerjaan) {
            $total_minutes = (int) $turnamen->durasi_pengerjaan;

            // waktu start = tanggal_pelaksanaan (jika disimpan) atau start_time
            $startTime = $turnamen->tanggal_pelaksanaan ?? $turnamen->start_time ?? null;
            if ($startTime && $agg->last_answered) {
                $lastAnswered = Carbon::parse($agg->last_answered);
                $start = Carbon::parse($startTime);
                $elapsedMinutes = max(0, $start->diffInSeconds($lastAnswered) / 60.0);
                $remaining = max(0, $total_minutes - $elapsedMinutes);
                $remaining_ratio = ($total_minutes > 0) ? ($remaining / $total_minutes) : 0.0;
            } else if ($turnamen->end_time && $agg->last_answered) {
                // fallback: hitung remaining = end_time - last_answered
                $end = Carbon::parse($turnamen->end_time);
                $lastAnswered = Carbon::parse($agg->last_answered);
                $remainingSeconds = max(0, $end->diffInSeconds($lastAnswered));
                $remaining_ratio = ($total_minutes * 60 > 0) ? ($remainingSeconds / ($total_minutes * 60)) : 0.0;
            }
        }

        $speed_bonus = $remaining_ratio * 20;

        $total = $base_score + $accuracy_bonus + $speed_bonus;
        return round($total, 2);
    }

    /**
     * Hitung skor tim: rata-rata skor anggota (jika peserta adalah tim,
     * skor anggota diambil dari jawaban per penguna -> mapping via tim_anggota)
     */
    public static function calculateTeamScore(int $id_tim, int $id_turnamen): float
    {
        // ambil anggota tim
        $anggota = DB::table('tim_anggota')->where('id_tim', $id_tim)->pluck('id_pengguna')->toArray();
        if (empty($anggota)) {
            // jika tidak ada anggota, fallback ke 0
            return 0.0;
        }

        // mapping: temukan id_peserta di pesertaturnamen untuk tim ini
        $part = DB::table('pesertaturnamen')->where('id_turnamen', $id_turnamen)->where('id_tim', $id_tim)->first();
        if (!$part) {
            return 0.0;
        }
        $id_peserta = $part->id_peserta;

        // hitung skor tim berdasarkan jawaban yang tersimpan untuk id_peserta
        // jika Anda menyimpan jawaban per-user (menggunakan id_pengguna), Anda bisa hitung skor per anggota lalu rata-rata.
        // Di sini kita asumsikan setiap anggota menjawab sebagai dirinya sendiri dan jawaban disimpan di turnamen_jawaban_peserta dengan kolom id_pengguna
        $scores = [];
        foreach ($anggota as $u) {
            // cari jawaban yang berkaitan dengan pengguna (jika tabel menyimpan id_pengguna)
            $agg = DB::table('turnamen_jawaban_peserta')
                ->where('id_pengguna', $u)
                ->selectRaw('COUNT(*) as answered, SUM(is_correct) as correct, MAX(answered_at) as last_answered')
                ->first();
            if (!$agg) continue;
            $answered = (int) ($agg->answered ?? 0);
            $correct = (int) ($agg->correct ?? 0);

            // hitung skor anggota (pakai base + accuracy, speed ambiguous)
            $base = $correct * 10;
            $acc = ($answered>0) ? ($correct/$answered)*20 : 0;
            // speed per anggota agak sulit -> skip or estimate
            $s = $base + $acc;
            $scores[] = $s;
        }

        if (empty($scores)) return 0.0;
        $avg = array_sum($scores) / count($scores);
        return round($avg, 2);
    }
}
