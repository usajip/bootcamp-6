<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-6 w-full">
                @foreach($data as $item)
                <div class="p-6 bg-white border-b border-gray-200 max-w-[250px] w-full rounded-[12px] shadow-md">
                    <div class="flex justify-between">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">{{ $item['name'] }}</h3>
                            <p class="mt-2 text-2xl font-bold  text-{{ $item['color'] }}">{{ $item['count'] }}</p>
                        </div>
                        <span class="material-symbols-rounded text-{{ $item['color'] }} !text-3xl">{{ $item['icon'] }}</span>
                    </div>
                    <sub>{{ $item['description'] }}</sub>
                </div>
                @endforeach
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-[20px] mt-5">
                <h3 class="text-lg font-semibold mb-4">Transactions in Last 7 Days</h3>
                <canvas id="transactionsChart" height="100">
                    {{-- Chart will be rendered here --}}
                </canvas>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-[20px] mt-5">
                {{-- Latest Transactions --}}
                <div class="flex justify-between gap-2">
                <h3 class="text-lg font-semibold mb-4">Latest Transactions</h3>
                <a href="#!" class="text-blue-600 hover:underline mb-4 self-center">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($latestTransactionOnTable as $transaction)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction['id'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction['user'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp{{ number_format($transaction['amount'], 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ \Carbon\Carbon::parse($transaction['date'])->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($transaction['status'] === 'completed')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                    @elseif($transaction['status'] === 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Failed</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('transactionsChart').getContext('2d');
    const transactionsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($transactionChart['labels']),
            datasets: [
                {
                    label: 'Transactions',
                    data: @json($transactionChart['data']),
                    borderColor: 'rgba(59, 130, 246, 1)',
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y',
                },
                {
                    label: 'Nominal (Rp)',
                    data: @json($transactionChart['nominal']),
                    borderColor: 'rgba(16, 185, 129, 1)',
                    backgroundColor: 'rgba(16, 185, 129, 0.15)',
                    fill: true,
                    tension: 0.4,
                    yAxisID: 'y1',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            if (context.dataset.label === 'Nominal (Rp)') {
                                return context.dataset.label + ': Rp' + context.parsed.y.toLocaleString('id-ID');
                            }
                            return context.dataset.label + ': ' + context.parsed.y;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Transactions'
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false,
                    },
                    title: {
                        display: true,
                        text: 'Nominal (Rp)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });
</script>
</x-app-layout>
