<x-layout title="Novo Usuário">
    <form method="post">
        @csrf
        <div class="form-group">
            <label for="name">Nome</label>
            <input type="text", name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email", name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password", name="password" id="password" class="form-control">
        </div>

        <button>
            Registrar
        </button>
        
    </form>
</x-layout>