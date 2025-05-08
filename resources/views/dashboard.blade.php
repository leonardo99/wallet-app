<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-8 grid grid-cols-1 gap-2 md:grid-cols-3">
        <div class="sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <p class="pl-6 pt-6 pb-2 text-gray-600 font-thin text-sm">
                    Saldo em carteira
                </p>
                <p class="pl-6 pb-6 text-gray-900 font-bold">
                    {{ $balance->getBalance() }}
                </p>
                <div class="mx-6 my-4 flex justify-between sm:justify-start sm:gap-x-2">
                    <a href="{{route('transaction.deposit.create')}}" class="p-2 bg-blue-100 hover:bg-blue-200 focus:bg-blue-200 active:bg-blue-200 text-sm text-blue-500 rounded-sm cursor-pointer flex items-center gap-1"><x-bi-arrow-up-circle /> Depositar dinheiro</a>
                    <a href="{{route('transaction.withdraw.create')}}" class="p-2 bg-blue-100 hover:bg-blue-200 focus:bg-blue-200 active:bg-blue-200 text-sm text-blue-500 rounded-sm cursor-pointer flex items-center gap-1"><x-bi-arrow-down-circle /> Transferir dinheiro</a>
                </div>
            </div>
        </div>
        <div class="sm:col-span-2 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <p class="pl-6 pt-6 pb-2 text-gray-600 font-bold text-base flex gap-1 items-center">
                    <x-bi-cash-coin class="w-5 h-5"/> Transações
                </p>
                <ul>
                    @forelse ($transactions as $transaction)
                    <li>
                        <a href="{{ route('transaction.show', $transaction) }}" class="px-6 py-2 grid grid-cols-12 text-sm items-center hover:bg-gray-100">
                            <span class="col-span-2 sm:col-span-1">
                                @if ($transaction->getTypeTransaction() === 'input')
                                <x-bi-arrow-up-circle class="w-7 h-7"/>
                                @elseif($transaction->getTypeTransaction() === 'output')
                                <x-bi-arrow-down-circle class="w-7 h-7"/>
                                @endif
                            </span>
                            <span class="col-span-8 sm:sm:col-span-9">
                                <p>{{ $transaction->getStatusTransaction() }}</p>
                                <p class="text-gray-600">{{ $transaction->getBeneficiary() }}</p>
                            </span> 
                            <span class="text-right col-span-2">
                               <p>{{ $transaction->getAmount() }}</p>
                               <p class="text-gray-600">{{ $transaction->getHour() }}</p>
                            </span> 
                        </a>
                    </li>  
                    @empty
                        
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
