<div>
    <h1 class="text-xl font-bold mb-4">Rent Increase Planning Tool</h1>

    <!-- Input for Desired Annual Rent -->
    <div class="mb-4">
        <label for="desiredRent" class="block text-sm font-medium text-gray-700">Desired Annual Rent</label>
        <input type="number" wire:model="desiredRent" id="desiredRent" class="mt-1 block w-full p-2 border rounded">
        @error('desiredRent')
            <span class="text-red-500 text-sm">{{ $message }}</span>
        @enderror
        <button wire:click="calculateRentPlan" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Calculate</button>
    </div>

    <!-- Line Graph -->
    <div class="mb-8" style="position: relative; height: 400px; width: 100%;">
        <canvas id="rentChart"></canvas>
    </div>

    <!-- Monthly Revenue Projections -->
    <div class="mb-4">
        <h2 class="text-lg font-semibold mb-2">Monthly Revenue Projections</h2>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-2">Month</th>
                    <th class="border p-2">Monthly Rent</th>
                    <th class="border p-2">Cumulative Rent</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $cumulativeRent = 0;
                    $previousRent = 0;
                @endphp
                @foreach ($monthlyProjections as $month => $rent)
                    @php
                        $cumulativeRent += $rent;
                        $increase = $previousRent > 0 ? (($rent - $previousRent) / $previousRent) * 100 : 0;
                        $hasIncrease = $increase > 0;
                        $previousRent_show = $previousRent;
                        $previousRent = $rent;

                        // Check if this month is in the increase points
                        $increasePercentage = null;
                        foreach ($chartData['annotations'] ?? [] as $annotation) {
                            if (isset($annotation['value']) && $annotation['value'] === array_search($month, $chartData['labels'] ?? [])) {
                                $increasePercentage = $annotation['percentage'];
                                break;
                            }
                        }
                    @endphp
                    <tr class="border">
                        <td class="border p-2 text-center">{{ $month }}</td>
                        <td class="border p-2 text-center">
                            ${{ number_format($rent, 2) }}
                            @if ($increasePercentage)
                                <span class="text-red-500 font-semibold ml-1">({{ number_format($previousRent_show,2) }} +{{ number_format($rent - $previousRent_show ,2) }} )</span>
                            @endif
                        </td>
                        <td class="border p-2 text-center">
                            ${{ number_format($cumulativeRent, 2) }}
                            @if ($increasePercentage)
                                <span class="text-red-500 font-semibold ml-1">(+{{ $increasePercentage }}%)</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



    <script>
        document.addEventListener('livewire:init', () => {
            // Check if Chart.js is loaded
            if (typeof Chart === 'undefined') {
                console.error('Chart.js is not loaded');
                return;
            }

            // Create a custom tooltip for annotation lines
            const customAnnotationTooltip = (context) => {
                const percentage = context.element.options.label.content.split('+')[1].split('%')[0];
                return `Rent Increase: +${percentage}%`;
            };

            Livewire.on('updateChart', (event) => {
                const ctx = document.getElementById('rentChart').getContext('2d');
                const chartData = event.data;

                // Destroy existing chart instance if it exists
                if (window.rentChart instanceof Chart) {
                    window.rentChart.destroy();
                }

                // Convert annotations to the format expected by the plugin
                // Convert annotations to the format expected by the plugin
                // Convert annotations to the format expected by the plugin
                // Convert annotations to the format expected by the plugin
                const annotations = {};

                chartData.annotations.forEach((annotation, index) => {
                    annotations[`line${index + 1}`] = {
                        type: 'line',
                        scaleID: 'x',
                        value: annotation.value,
                        borderColor: 'red',
                        borderWidth: 2,
                        // Remove or hide the label
                        label: {
                            display: false // Set to false to hide the label completely
                        },
                        // We'll handle the tooltip display through Chart.js tooltip callbacks
                    };
                });

                // Create new chart instance
                window.rentChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Cumulative Rent',
                            data: chartData.data,
                            borderColor: 'blue',
                            fill: true,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Cumulative Rent ($)'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return '$' + value.toLocaleString();
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Month'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let result = 'Cumulative Rent: $' + context.parsed.y
                                            .toLocaleString();

                                        // Check if we're at a month with a rent increase
                                        const monthIndex = context.dataIndex;

                                        // Look through annotations to see if any match this month
                                        for (const key in annotations) {
                                            const annotation = annotations[key];
                                            if (annotation.value === monthIndex) {
                                                // Find the matching original annotation to get the percentage
                                                const originalAnnotation = chartData.annotations
                                                    .find(a =>
                                                        a.value === monthIndex);

                                                if (originalAnnotation) {
                                                    result += '\nRent Increase: +' +
                                                        originalAnnotation.percentage + '%';
                                                }
                                            }
                                        }

                                        return result;
                                    }
                                }
                            },
                            annotation: {
                                annotations: annotations,
                                drawTime: 'afterDatasetsDraw'
                            }
                        }
                    }
                });
            });
        });
    </script>
</div>
