<style>
    .sidebar {
        background: #0b2239;
        width: 250px;
        min-height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        padding: 30px 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 2px 0 15px rgba(0,0,0,0.4);
    }

    .sidebar h1 {
        font-family: 'Black Ops One', cursive;
        font-size: 26px;
        color: #38bdf8;
        text-align: center;
        margin-bottom: 40px;
    }

    .sidebar a {
        display: block;
        color: #a0aec0;
        padding: 10px 15px;
        margin: 5px 0;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.3s;
        font-weight: 500;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background: #1e3a8a;
        color: #fff;
    }
</style>

<div class="sidebar">
    <div>
        <h1>Guru Panel</h1>

        <a href="{{ route('guru.dashboard') }}"
           class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
            🏠 Dashboard
        </a>

        <a href="{{ route('guru.soal.index') }}"
            class="{{ request()->routeIs('guru.soal.index') ? 'active' : '' }}">
            📘 Bank Soal
        </a>

        <a href="{{ route('guru.tournament.index') }}"
           class="{{ request()->routeIs('guru.tournament.index') ? 'active' : '' }}">
            🏆 Turnamen
        </a>
    </div>

    <div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="block w-full text-left px-4 py-2 text-white-400 hover:text-cyan-500 transition">
                🚪 Logout
            </button>
        </form>
    </div>
</div>
