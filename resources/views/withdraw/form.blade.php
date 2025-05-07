<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transferir saldo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg py-6">
                <div class="border-b border-b-gray-100 px-6 pb-6">
                    <p class="font-bold">Informe o destinatário da transferência</p>
                    <p class="font-thin text-sm">Digite a chave da pessoa que vai receber o valor.</p>
                    <p class="font-bold text-sm mt-2">Saldo em carteira <span class="font-thin">{{ $balance }}</span></p>
                </div>
                <form action="{{route('transaction.withdraw.store')}}" method="post">
                    @csrf
                    <div class="flex flex-col sm:flex-row pb-6">
                        <div class="px-6 mt-3 flex flex-col w-full sm:w-2/3">
                            <label for="id" class="text-sm font-medium text-gray-700 mb-1">Chave</label>
                            <input type="text" id="id" name="id" value="{{old('id')}}"
                              class="py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('id') border-red-700 ring-red-700 focus:ring-red-700 focus:border-red-700 @enderror" />
                            @error('id')
                                <p class="text-xs font-thin font-medium text-red-700 my-1">{{ $message }}</p>                            
                            @enderror
                        </div>
                    
                        <div class="px-6 mt-3 flex flex-col w-full sm:w-1/2">
                            <label for="amount" class="text-sm font-medium text-gray-700 mb-1">Valor (R$)</label>
                            <input type="text" id="amount" name="amount" value="{{old('amount')}}"
                                class="px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('amount') border-red-700 ring-red-700 focus:ring-red-700 focus:border-red-700 @enderror" />
                            @error('amount')
                                <p class="text-xs font-thin font-medium text-red-700 my-1">{{ $message }}</p>                            
                            @enderror
                        </div>
                    </div>
                    <div class="border-t border-t-gray-100 px-6 pt-6 justify-items-end">
                        <button class="p-2 bg-blue-100 hover:bg-blue-200 focus:bg-blue-200 active:bg-blue-200 text-sm text-blue-500 rounded-sm cursor-pointer flex items-center gap-1"><x-bi-arrow-up-circle /> Transferir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('js')
        <script>
            var amountInput = document.getElementById('amount');
            var keyInput = document.getElementById('id');
            var amountMaskOptions = {
                mask: '********-****-****-****-************',
                prepare: (str) => str.toLowerCase().replace(/[^a-f0-9]/g, ''),
                blocks: {
                    '*': {
                    mask: /^[a-f0-9]$/
                    }
                }
            };

            var keyIdMaskOptions = {
                mask: Number,
                scale: 2,
                signed: false,
                thousandsSeparator: '.',
                padFractionalZeros: true,
                normalizeZeros: true,
                radix: ',',
                mapToRadix: ['.']
            };
            var keyMask = IMask(keyInput, amountMaskOptions);
            var amountMask = IMask(amountInput, amountMaskOptions);
        </script>
    @endpush
</x-app-layout>
