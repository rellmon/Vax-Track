@extends('layouts.admin')

@section('page-title', 'Advanced Analytics')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-lg-8">
            <h2 class="mb-0" style="color: #52796f; font-weight: 600;"><i class="bi bi-graph-up"></i> Advanced Analytics & Insights</h2>
            <p class="text-muted mt-2">Visualize clinic performance trends and patterns</p>
        </div>
        <div class="col-lg-4 text-end">
            <form method="GET" class="row g-2" style="display: inline-flex; gap: 10px;">
                <div>
                    <label class="form-label" style="font-size: 12px; margin-bottom: 5px; display: block;">From:</label>
                    <input type="date" name="from" class="form-control form-control-sm" value="{{ $from }}" style="font-size: 12px; padding: 6px;">
                </div>
                <div>
                    <label class="form-label" style="font-size: 12px; margin-bottom: 5px; display: block;">To:</label>
                    <input type="date" name="to" class="form-control form-control-sm" value="{{ $to }}" style="font-size: 12px; padding: 6px;">
                </div>
                <div style="margin-top: 20px;">
                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Revenue Trend -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <h5 style="color: #2f3e46; font-weight: 600; margin-bottom: 15px;"><i class="bi bi-wallet2"></i> Revenue Trend</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Appointment Status -->
        <div class="col-lg-6">
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <h5 style="color: #2f3e46; font-weight: 600; margin-bottom: 15px;"><i class="bi bi-calendar-event"></i> Appointment Trends</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="appointmentChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Vaccine Popularity & Age Groups -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <h5 style="color: #2f3e46; font-weight: 600; margin-bottom: 15px;"><i class="bi bi-syringe"></i> Most Administered Vaccines</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="vaccineChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <h5 style="color: #2f3e46; font-weight: 600; margin-bottom: 15px;"><i class="bi bi-people"></i> Population by Age Group</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="ageGroupChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row">
        <div class="col-lg-3 col-md-6 mb-3">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;">
                <div style="font-size: 24px; font-weight: 700;">{{ count($revenueChartData['labels']) }}</div>
                <div style="font-size: 12px; opacity: 0.9;">Days in Period</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;">
                <div style="font-size: 24px; font-weight: 700;">{{ array_sum($vaccinePopularityData['data']) }}</div>
                <div style="font-size: 12px; opacity: 0.9;">Vaccines Given</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;">
                <div style="font-size: 24px; font-weight: 700;">{{ array_sum($ageGroupAnalytics['data']) }}</div>
                <div style="font-size: 12px; opacity: 0.9;">Children</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 20px; border-radius: 10px; text-align: center;">
                <div style="font-size: 24px; font-weight: 700;">{{ count($vaccinePopularityData['labels']) }}</div>
                <div style="font-size: 12px; opacity: 0.9;">Top Vaccines</div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($revenueChartData['labels']),
            datasets: [{
                label: 'Revenue',
                data: @json($revenueChartData['data']),
                borderColor: '#52796f',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                tension: 0.4,
                fill: true,
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: function(v) { return '₱' + v; } }
                }
            }
        }
    });

    // Appointment Chart
    const apptCtx = document.getElementById('appointmentChart').getContext('2d');
    new Chart(apptCtx, {
        type: 'line',
        data: {
            labels: @json($appointmentTrends['labels']),
            datasets: [
                {
                    label: 'Scheduled',
                    data: @json($appointmentTrends['scheduled']),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                },
                {
                    label: 'Completed',
                    data: @json($appointmentTrends['completed']),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                },
                {
                    label: 'Cancelled',
                    data: @json($appointmentTrends['cancelled']),
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true } }
        }
    });

    // Vaccine Chart
    const vaccineCtx = document.getElementById('vaccineChart').getContext('2d');
    new Chart(vaccineCtx, {
        type: 'bar',
        data: {
            labels: @json($vaccinePopularityData['labels']),
            datasets: [{
                label: 'Number Administered',
                data: @json($vaccinePopularityData['data']),
                backgroundColor: '#8b5cf6',
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } }
        }
    });

    // Age Group Chart
    const ageCtx = document.getElementById('ageGroupChart').getContext('2d');
    new Chart(ageCtx, {
        type: 'doughnut',
        data: {
            labels: @json($ageGroupAnalytics['labels']),
            datasets: [{
                data: @json($ageGroupAnalytics['data']),
                backgroundColor: ['#ff6384', '#36a2eb', '#ffce56', '#4bc0c0', '#9966ff'],
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
