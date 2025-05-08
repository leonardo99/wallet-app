<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalhes da transação
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-3 bg-white overflow-hidden shadow-sm sm:rounded-lg py-6 flex flex-col items-center">
                <div>
                    <p><span class="font-bold">Id da transação:</span> {{ $transaction->id }}</p>
                    <p class="text-gray-500 font-thin text-sm text-center">{{ $transaction->getDate() }}</p>
                </div>
                <p class="font-bold text-xl"> {{ $transaction->getAmount() }}</p>
                <div class="flex justify-center items-center gap-1">
                    <p class="font-thin">
                        @if ($transaction->getStatusTransaction() === 'enviada')
                        <x-uni-money-withdraw-o class="w-5 h-5" />  
                        @elseif($transaction->getStatusTransaction() === 'recebida')
                        <x-uni-money-insert-o class="w-5 h-5" />  
                        @endif 
                    </p>
                    <p class="font-thin text-xl">
                        {{ $transaction->getStatusTransaction() }}
                    </p>
                </div>
                <p>{{ $transaction->getBeneficiary() }}</p>
                @can('update', $transaction)
                    <button id="refund-value" class="p-2 bg-blue-100 hover:bg-blue-200 focus:bg-blue-200 active:bg-blue-200 text-sm text-blue-500 rounded-sm cursor-pointer flex items-center gap-1">
                        <x-bi-arrow-down-circle /> Devolver valor
                    </button>
                    <form id="refund-form" method="POST" action="{{ route('transaction.refund', $transaction) }}" class="hidden">
                        @csrf
                    </form>
                @endcan
            </div>
        </div>
    </div>
    @push('js')
        <script>
            @can('update', $transaction)
            const transaction = @json($transaction);
            document.querySelector("#refund-value").addEventListener('click', () => {
                Swal.fire({
                    title: 'Devolver valor',
                    html: `
                        <div class="text-left text-sm">
                            <p><span class="font-bold">Saldo disponível:</span> {{ auth()->user()->account->getBalance() }}</p>
                            <p><span class="font-bold">Você vai devolver:</span> {{ $transaction->getAmountFormated() }}</p>
                            <p><span class="font-bold">Para:</span> {{ $transaction->senderAccount->user->name }}</p>
                            <p><span class="font-bold">Chave de destino:</span> {{ $transaction->sender_account_id }}</p>
                        </div>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Confirmar',
                    cancelButtonText: 'Cancelar',
                    customClass: {
                        title: 'text-xl',
                        confirmButton: 'bg-blue-100 hover:bg-blue-200 focus:bg-blue-200 active:bg-blue-200 text-sm text-blue-500',
                        cancelButton: 'bg-grey-100 hover:bg-grey-200 focus:bg-grey-200 active:bg-grey-200 text-sm text-grey-500',
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('refund-form').submit();
                    }
                });
            })
            @endcan
        </script>
    @endpush
</x-app-layout>
