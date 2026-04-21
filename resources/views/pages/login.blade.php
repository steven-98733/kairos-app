@extends('layouts.app')

@section('page')

<div class="background">
    <div class="overlay">
        <div class="header">
            <h1>KAIRO<span>S</span></h1>
            <div class="menu-btn" onclick="goMenu()">☰</div>
        </div>

        <!-- LOGIN BOX -->
        <div class="login-box">
            <h2>Identification</h2>

            <input type="text" placeholder="Identifiant">
            <input type="password" placeholder="Mot de passe">

            <button>SE CONNECTER</button>

            <a href="#">Mot de passe oublié</a>
        </div>

    </div>
</div>

<style>
.background {
    width: 100%;
    min-height: 100vh;
    background-image: url('{{ asset('images/IMG_2233.JPG') }}');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.overlay {
    min-height: 100vh;
    background: rgba(0, 0, 0, 0.22);
    backdrop-filter: blur(2px);
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px;
    color: white;
    background: rgba(0, 0, 0, 0.5);
}

.header h1 span {
    color: #2ec4b6;
}

.menu-btn {
    font-size: 28px;
    cursor: pointer;
}

/* LOGIN */
.login-box {
    width: 90%;
    max-width: 350px;
    margin: 80px auto;
    background: rgba(255,255,255,0.9);
    padding: 25px;
    border-radius: 10px;
    text-align: center;
}

.login-box h2 {
    color: #2ec4b6;
}

.login-box input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: none;
    background: #eee;
    border-radius: 5px;
}

.login-box button {
    width: 100%;
    padding: 12px;
    background: #2ec4b6;
    border: none;
    color: white;
    font-weight: bold;
    margin-top: 10px;
    border-radius: 5px;
}

.login-box a {
    display: block;
    margin-top: 10px;
    color: #3498db;
}
</style>

<script>
function goMenu(){
    window.location.href = "/menu";
}
</script>

@endsection
