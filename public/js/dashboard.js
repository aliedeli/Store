document.addEventListener('DOMContentLoaded', function() {
    // Fetch database stats
    function fetchStats() {
        fetch('/App/handlers',ptions = {
            method: 'POST'})
            .then(response => response.json())
            .then(data => {
                console.log(data);
                document.getElementById('userCount').textContent = data.userCount;
                document.getElementById('dbSize').textContent = data.dbSize;
                 document.getElementById('tableCount').textContent = data.tableCount;
            })
             .catch(error => console.error('Error:', error));
    }

    // Initialize Chart.js
    function initChart() {
        const ctx = document.getElementById('dbChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{

                    label: 'Database Growth',
                    data: [12, 19, 3, 5, 2, 3],
                    fill: false,
                    
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: '#3e95cd',
                    tension: 0.4
                    
                }]
            },
            options: {
                
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    // Initial load
    fetchStats();
    initChart();

    // Refresh stats every 5 minutes
    setInterval(fetchStats, 300000);
});
