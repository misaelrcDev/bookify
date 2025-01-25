<x-filament-panels::page>
    <div class="flex flex-col items-center justify-center h-screen p-2 bg-gray-100 rounded-lg dark:bg-gray-800">
        <div class="w-full max-w-lg p-6 mt-2 bg-white rounded-lg shadow-md dark:bg-gray-900">
            <h2 class="mb-4 text-lg font-bold text-gray-900 dark:text-gray-100">Gerenciar Assinatura</h2>

            @if (session('success'))
                <div class="p-2 mb-4 text-green-700 bg-green-100 border border-green-400 rounded dark:text-green-400 dark:bg-green-900 dark:border-green-600">
                    {{ session('success') }}
                </div>
            @endif

            <form id="subscription-form" action="{{ route('filament.pages.subscription.update') }}" method="POST">
                @csrf
                <label for="plan" class="block mb-2 text-gray-700 dark:text-gray-300">Selecione o Plano</label>
                <select name="plan" id="plan" class="w-full p-2 mb-4 bg-white border border-gray-300 rounded dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600">
                    <option value="price_id_free">Gratuito</option>
                    <option value="price_1QkP5tKNXZPgsmL1KjyNiRLx">Básico - R$10/mês</option>
                    <option value="price_1QkPAtKNXZPgsmL1Uqs0b6Hi">Premium - R$30/mês</option>
                </select>
                <label for="card-element" class="block mb-2 text-gray-700 dark:text-gray-300">Método de Pagamento</label>
                <div id="card-element" class="w-full p-2 mb-4 bg-white border border-gray-300 rounded dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600"></div>
                <div id="card-errors" role="alert" class="mb-4 text-red-500"></div>
                <button type="submit" class="w-full p-2 text-white bg-blue-500 rounded hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700">Atualizar Assinatura</button>
            </form>

        </div>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ env('STRIPE_KEY') }}');
    const elements = stripe.elements();

    // Função para obter as cores baseadas no tema
    function getThemeStyles() {
        const isDarkMode = document.documentElement.classList.contains('dark');
        return {
            base: {
                color: isDarkMode ? '#ffffff' : '#32325d', // Branco no tema escuro, cinza no claro
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: isDarkMode ? '#bbbbbb' : '#aab7c4' // Cinza claro no escuro, mais escuro no claro
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };
    }

    // Inicializa o elemento de cartão com as cores do tema atual
    let cardElement = elements.create('card', { style: getThemeStyles() });
    cardElement.mount('#card-element');

    // Observa mudanças no tema e atualiza as cores
    const observer = new MutationObserver(() => {
        cardElement.update({ style: getThemeStyles() });
    });

    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

    // Gerenciamento do formulário
    const form = document.getElementById('subscription-form');
    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const { paymentMethod, error } = await stripe.createPaymentMethod('card', cardElement);

        if (error) {
            document.getElementById('card-errors').textContent = error.message;
        } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'paymentMethod');
            hiddenInput.setAttribute('value', paymentMethod.id);
            form.appendChild(hiddenInput);

            form.submit();
        }
    });
</script>

</x-filament-panels::page>
