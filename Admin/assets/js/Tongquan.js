
        const ctx1 = document.getElementById('chart1').getContext('2d');
        const ctx2 = document.getElementById('chart2').getContext('2d');
        const ctx3 = document.getElementById('chart3').getContext('2d');

        new Chart(ctx1, {
            type: 'doughnut',
            data: {
                labels: ['Data1', 'Data2', 'Data3', 'Data4'],
                datasets: [{
                    data: [25, 25, 25, 25],
                    backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745']
                }]
            }
        });

        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: [1, 2, 3, 4, 5],
                datasets: [
                    {label: 'Desktop', data: [100, 200, 300, 400, 500], borderColor: '#007bff'},
                    {label: 'Mobile', data: [50, 150, 250, 350, 450], borderColor: '#28a745'}
                ]
            }
        });

        new Chart(ctx3, {
            type: 'bar',
            data: {
                labels: [1, 2, 3, 4, 5],
                datasets: [
                    {label: 'Data1', data: [50, 100, 150, 200, 250], backgroundColor: '#ffc107'},
                    {label: 'Data2', data: [20, 40, 60, 80, 100], backgroundColor: '#dc3545'}
                ]
            }
        });
