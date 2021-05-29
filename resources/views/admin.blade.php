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
            <div class="order-overall-item rounded processing">
                <div style="font-size:1.15rem">
                    Đơn chưa xác nhận
                </div>
                <div>123</div>
            </div>
            <div class="order-overall-item rounded bg-primary">
                <div style="font-size:1.15rem">
                    Đơn đang giao
                </div>
                <div>123</div>
            </div>
            <div class="order-overall-item rounded bg-success">
                <div style="font-size:1.15rem">
                    Đơn đã giao
                </div>
                <div>123</div>
            </div>
            <div class="order-overall-item rounded bg-secondary">
                <div style="font-size:1.15rem">
                    Đơn đã huỷ
                </div>
                <div>123</div>
            </div>
        </div>

        <div class="my-5">
            <div class="d-flex  justify-content-between align-items-center">
                <div>Tổng doanh thu năm 2021: 78,000,000 vnđ</div>
                <div class="form-group w-25 d-flex align-items-end">
                    <label for="sel1" class="mr-2">Năm:</label>
                    <select class="form-control" id="sel1">
                        <option>2021</option>
                        <option>2019</option>
                        <option>2018</option>
                        <option>2000</option>
                    </select>
                </div>
            </div>
            <canvas width="400" id="revenueMonth"></canvas>
            <div style="text-align: center;font-weight:bold">Biểu đồ doanh thu theo từng tháng của năm</div>
        </div>
        <div class="my-5">
            <div class="d-flex  justify-content-between align-items-center">
                <div>Tổng doanh thu: 1,278,000,000 vnđ</div>
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
        dataOrder.forEach(({
            year,
            grand_total,
            month
        }) => {
            // if not exists year in covertData
            if (!convertData.find(i => i.year === year)) {
                convertData.push({
                    year,
                    // total grand_total of year
                    grand_total: dataOrder.reduce((a, b) => {
                        if (b.year === year)
                            return a + b.grand_total;
                        return a;
                    }, 0),
                    dataOfYear: [{
                        month,
                        // total grand_total of month of the year
                        grand_total: dataOrder.reduce((a, b) => {
                            if (b.year === year && b.month === month)
                                return a + b.grand_total;
                            return a;
                        }, 0)
                    }]
                })
            } else {
                const dataOfYear = convertData.find(i => i.year === year).dataOfYear;
                dataOfYear.push({
                    month,
                    // total grand_total of month of the year
                    grand_total: dataOrder.reduce((a, b) => {
                        if (b.year === year && b.month === month)
                            return a + b.grand_total;
                        return a;
                    }, 0)
                })
            }
        })

        convertData = convertData.sort((a, b) => parseInt(a.year) - parseInt(b.year));

        const labelMonth = [
            'Tháng 1',
            'Tháng 2',
            'Tháng 3',
            'Tháng 4',
            'Tháng 5',
            'Tháng 6',
            'Tháng 7',
            'Tháng 8',
            'Tháng 9',
            'Tháng 10',
            'Tháng 11',
            'Tháng 12',
        ];
        const dataMonth = {
            labels: labelMonth,
            datasets: [{
                label: 'Doanh thu',
                data: [5000000, 6000000, 7000000, 4000000, 5000000, 1000000, 8000000, 6000000, 11000000,
                    9000000, 8000000, 8000000
                ],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        };
        const configMonth = {
            type: 'line',
            data: dataMonth,
        };
        var revenueMonth = new Chart(
            document.getElementById('revenueMonth'),
            configMonth
        );

        const dataYear = {
            labels: [2018, 2019, 2020, 2021],
            datasets: [{
                label: 'Doanh thu',
                data: [5000000, 6000000, 7000000, 12000000],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        };

        var revenueYear = new Chart(
            document.getElementById('revenueYear'), {
                type: 'bar',
                data: dataYear,
            }
        );
        // const data = [{
        //         id: 1,
        //         amount: 2,
        //         year: 2012,
        //         month: 2
        //     },
        //     {
        //         id: 2,
        //         amount: 5,
        //         year: 2014,
        //         month: 6
        //     },
        //     {
        //         id: 3,
        //         amount: 12,
        //         year: 2012,
        //         month: 6
        //     }
        // ];

        // data = [
        //     {
        //         year: 2018,
        //         totalAmount: 5,
        //         dataOfYear: [{
        //             month: 6,
        //             amount: 5
        //         }]
        //     },
        //     {
        //         year: 2012,
        //         totalAmount: 14,
        //         dataOfYear: [{
        //                 month: 2,
        //                 amount: 2
        //             },
        //             {
        //                 month: 6,
        //                 amount: 12,
        //             }
        //         ]
        //     },
        //     {
        //         year: 2014,
        //         totalAmount: 5,
        //         dataOfYear: [{
        //             month: 6,
        //             amount: 5
        //         }]
        //     }
        // ]

    </script>
@endsection
