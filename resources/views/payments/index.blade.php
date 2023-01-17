@extends('layouts.layout')
@section('body')
    <div class="container mx-auto py-4">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <caption class="p-5 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800">
                    Zahtjevi za uplatu
                </caption>
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <div class="grid grid-cols-4">
                            <div class='p-2 col-span-2'>
                                <form action="{{route('payment.index')}}">
                                    <label for="default-search"
                                        class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                            </svg>
                                        </div>
                                        <input type="search" id="default-search"
                                            class="block w-full p-4 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Search Mockups, Logos..." 
                                            name="search" required>
                                        <button type="submit"
                                            class="text-white absolute right-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                                    </div>
                                </form>
                            </div>
                            <div></div>
                            <div class="my-auto ml-auto">
                                <a href="{{route("payment.create")}}" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                    <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                        Kreiraj zahtjev
                                    </span>
                                </a>
                            </div>
                        </div>

                    </tr>
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Opis troška
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Naziv projekta
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Osoba
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Cijena
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Opcije</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $payment->description }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $payment->project }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $payment->person }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $payment->cost }} KM
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('payment.edit', $payment->id) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                                <form action="{{route('payment.destroy', $payment->id)}}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class='py-3 px-3'>
                {{ $payments->links() }}
            </div>
        </div>
    </div>
    @if(session()->has('jsAlert'))
        <script>
            alert("{{ session()->get('jsAlert') }}");
        </script>
    @endif
@endsection
