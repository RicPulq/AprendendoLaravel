<x-layout title="Nova Série">
    <form action="/series/salvar" method="post">
        @csrf
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome"/>
        
        <button type="submit" class="btn">Submit</button>
    </form>
</x-layout>