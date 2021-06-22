@extends('layouts.app')
@section('content')
    <div class="border-bottom">
        <ul class="nav--header">
            <li><a href="#">Trang chủ</a></li>
        </ul>
        <h1>Tổng quan</h1>
    </div>
    <div class="mt-4">
        <div class="container-list ">
            <div onclick="location.href='{{ route('orders.index', ['type' => 'processing']) }}'"
                class="order-overall-item rounded processing">
                <div style="font-size:1.15rem">
                    Đơn chưa xác nhận
                </div>
                <div>{{ $count['processing'] }}</div>
            </div>
            <div onclick="location.href='{{ route('orders.index', ['type' => 'shipping']) }}'"
                class="order-overall-item rounded bg-primary">
                <div style="font-size:1.15rem">
                    Đơn đang giao
                </div>
                <div>{{ $count['shipping'] }}</div>
            </div>
            <div onclick="location.href='{{ route('orders.index', ['type' => 'delivered']) }}'"
                class="order-overall-item rounded bg-success">
                <div style="font-size:1.15rem">
                    Đơn đã giao
                </div>
                <div>{{ $count['delivered'] }}</div>
            </div>
            <div onclick="location.href='{{ route('orders.index', ['type' => 'cancel']) }}'"
                class="order-overall-item rounded bg-secondary">
                <div style="font-size:1.15rem">
                    Đơn đã huỷ
                </div>
                <div>{{ $count['cancel'] }}</div>
            </div>
        </div>

        <div class="my-5">
            <div class="d-flex  justify-content-between align-items-center">
                <div id="grand_total_year">Tổng doanh thu năm 2021: 0 vnđ</div>
                <div class="form-group w-25 d-flex align-items-end">
                    <label for="sel1" class="mr-2">Năm:</label>
                    <select class="form-control" id="selected-year">
                    </select>
                </div>
            </div>
            <canvas width="400" id="revenueMonth"></canvas>
            <div style="text-align: center;font-weight:bold">Biểu đồ doanh thu theo từng tháng của năm</div>
        </div>
        <div class="my-5">
            <div class="d-flex  justify-content-between align-items-center">
                <div id="grand_total_month">Tổng doanh thu: 0 vnđ</div>
            </div>
            <canvas width="400" id="revenueYear"></canvas>
            <div style="text-align: center;font-weight:bold">Biểu đồ doanh thu theo từng năm</div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        const dataOrder = @json($orders);
        let convertData = [];
        const defaultDataOfYear = [{
                month: "01",
                grand_total: 0
            },
            {
                month: "02",
                grand_total: 0
            },
            {
                month: "03",
                grand_total: 0
            },
            {
                month: "04",
                grand_total: 0
            },
            {
                month: "05",
                grand_total: 0
            },
            {
                month: "06",
                grand_total: 0
            },
            {
                month: "07",
                grand_total: 0
            },
            {
                month: "08",
                grand_total: 0
            },
            {
                month: "09",
                grand_total: 0
            },
            {
                month: "10",
                grand_total: 0
            },
            {
                month: "11",
                grand_total: 0
            },
            {
                month: "12",
                grand_total: 0
            },
        ]
        dataOrder.forEach(({
            year,
            grand_total,
            month
        }) => {
            // if not exists year in covertData
            const indexOfMonth = defaultDataOfYear.findIndex(i => i.month == month);
            if (!convertData.find(i => i.year === year)) {
                convertData.push({
                    year,
                    // total grand_total of year
                    grand_total: dataOrder.reduce((a, b) => {
                        if (b.year === year)
                            return a + b.grand_total;
                        return a;
                    }, 0),
                    dataOfYear: [...defaultDataOfYear.slice(0, indexOfMonth), {
                            month,
                            // total grand_total of month of the year
                            grand_total: dataOrder.reduce((a, b) => {
                                if (b.year === year && b.month === month)
                                    return a + b.grand_total;
                                return a;
                            }, 0)
                        },
                        ...defaultDataOfYear.slice(0, indexOfMonth + 1)
                    ]
                })
            } else {
                const dataOfYear = convertData.find(i => i.year === year).dataOfYear;
                dataOfYear = [...defaultDataOfYear.slice(0, indexOfMonth), {
                        month,
                        // total grand_total of month of the year
                        grand_total: dataOrder.reduce((a, b) => {
                            if (b.year === year && b.month === month)
                                return a + b.grand_total;
                            return a;
                        }, 0)
                    },
                    ...defaultDataOfYear.slice(0, indexOfMonth + 1)
                ]
            }
        })

        convertData = convertData.sort((a, b) => parseInt(b.year) - parseInt(a.year));
        const selectedYear = document.getElementById('selected-year');
        const currentYear = (new Date()).getFullYear();
        const grand_total_year = document.getElementById('grand_total_year');
        const grand_total_month = document.getElementById('grand_total_month');

        const showChartMonth = (year = currentYear) => {
            const data = convertData.find(i => i.year == year);
            grand_total_year.innerHTML =
                `Tổng doanh thu năm ${year}: ${data.grand_total.toLocaleString('it-IT', {style : 'currency', currency : 'VND'})}`
            const dataOfMonth = data.dataOfYear.map(item => item.grand_total);
            new Chart(
                document.getElementById('revenueMonth'), {
                    type: 'line',
                    data: {
                        labels: defaultDataOfYear.map(i => `Tháng ${i.month}`),
                        datasets: [{
                            label: 'Doanh thu',
                            data: dataOfMonth,
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                }
            );
        }

        showChartMonth(currentYear);

        if (!convertData.find(i => i.year == currentYear)) {
            const option = document.createElement('option');
            option.value = currentYear;
            option.innerHTML = currentYear;
            selectedYear.appendChild(option);
        }
        convertData.forEach(item => {
            const option = document.createElement('option');
            option.value = item.year;
            option.innerHTML = item.year;
            selectedYear.appendChild(option);
        })

        selectedYear.addEventListener('change', e => {
            showChartMonth(e.target.value);
        })


        const dataYear = {
            labels: convertData.map(i => i.year),
            datasets: [{
                label: 'Doanh thu',
                data: convertData.map(i => i.grand_total),
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        };
        const total = convertData.reduce((a,b)=>{
            return b.grand_total + a;
        },0)
        grand_total_month.innerHTML =
                `Tổng doanh thu: ${total.toLocaleString('it-IT', {style : 'currency', currency : 'VND'})}`
        var revenueYear = new Chart(
            document.getElementById('revenueYear'), {
                type: 'bar',
                data: dataYear,
            }
        );
    </script>
@endsection
