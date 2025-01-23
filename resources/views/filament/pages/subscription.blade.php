{{-- <x-filament-panels::page>

</x-filament-panels::page> --}}


<x-filament::page>
    <h2 class="text-lg font-bold mb-4">Gerenciar Assinatura</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('filament.pages.subscription') }}" method="POST">
        @csrf
        <label for="plan" class="block mb-2">Selecione o Plano</label>
        <select name="plan" id="plan" class="form-control mb-4">
            <option value="price_id_free">Gratuito</option>
            <option value="price_id_basic">Básico - R$10/mês</option>
            <option value="price_id_premium">Premium - R$30/mês</option>
        </select>

        <label for="paymentMethod" class="block mb-2">Método de Pagamento</label>
        <input type="text" id="paymentMethod" name="paymentMethod" class="form-control mb-4" required>

        <button type="submit" class="btn btn-primary">Atualizar Assinatura</button>
    </form>
</x-filament::page>
