<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <p class="pl-6 pt-6 pb-2 text-gray-600 font-thin text-sm">
                    Saldo em carteira
                </p>
                <p class="pl-6 pb-6 text-gray-900 font-bold">
                    R$ 0,00
                </p>
                <div class="mx-6 my-4 flex gap-x-2">
                    <a class="p-2 bg-blue-100 hover:bg-blue-200 focus:bg-blue-200 active:bg-blue-200 text-sm text-blue-500 rounded-sm cursor-pointer flex items-center gap-1"><x-bi-arrow-up-circle /> Depositar dinheiro</a>
                    <a class="p-2 bg-blue-100 hover:bg-blue-200 focus:bg-blue-200 active:bg-blue-200 text-sm text-blue-500 rounded-sm cursor-pointer flex items-center gap-1"><x-bi-arrow-down-circle /> Transferir dinheiro</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
