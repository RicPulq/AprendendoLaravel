<x-layout title="Login">
    <form method="post">
        @csrf
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email", name="email" id="email" class="form-control">
            <label for="password">Senha</label>
            <input type="password", name="password" id="password" class="form-control">

            <button>Entrar</button>
        </div>
    </form>
</x-layout>