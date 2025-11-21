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
        // Pertama: coba ambil row peserta yang mewakili tim (biasanya dibuat saat startTournament)
        $part = DB::table('pesertaturnamen')
            ->where('id_turnamen', $id_turnamen)
            ->where('id_tim', $id_tim)
            ->first();

        if ($part && isset($part->id_peserta)) {
            // Jika ada peserta yang mewakili tim, hitung skor berdasarkan jawaban pada peserta tersebut
            return self::calculateParticipantScore((int)$part->id_peserta, $id_turnamen);
        }

        // Jika tidak ada peserta tim (mis. struktur menyimpan jawaban per-user), fallback: hitung rata-rata skor peserta per anggota
        $scores = [];
        foreach ($anggota as $u) {
            // cari pesertaturnamen untuk setiap anggota (id_pengguna)
            $p = DB::table('pesertaturnamen')
                ->where('id_turnamen', $id_turnamen)
                ->where('id_pengguna', $u)
                ->first();

            if ($p && isset($p->id_peserta)) {
                $scores[] = self::calculateParticipantScore((int)$p->id_peserta, $id_turnamen);
            }
        }

        if (empty($scores)) return 0.0;
        $avg = array_sum($scores) / count($scores);
        return round($avg, 2);
    }
}
