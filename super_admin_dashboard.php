<?php session_start();
$pageTitle = "Super Admin Dashboard";
require_once('connection.php');
require_once('sessionSet.php');
require_once('Functions.php');

// We use the merged database for the dashboard
mysqli_select_db($con, 'ds_ctpfsd_merged');

// Fetch KPIs
$totalStudents = $con->query("SELECT count(*) FROM students")->fetch_row()[0] ?? 0;
$totalAdmissions = $con->query("SELECT count(*) FROM admissions")->fetch_row()[0] ?? 0;
$monthlyAdmissions = $con->query("SELECT count(*) FROM admissions WHERE month(created_at) = month(curdate()) and year(created_at) = year(curdate())")->fetch_row()[0] ?? 0;
$totalSchools = $con->query("SELECT count(*) FROM schools")->fetch_row()[0] ?? 0;

// Chart 1: Admissions Trend (Last 6 Months)
$trendData = $con->query("SELECT DATE_FORMAT(created_at, '%b') as month_name, count(*) as count 
    FROM admissions 
    WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH) 
    GROUP BY month_name, DATE_FORMAT(created_at, '%Y-%m') 
    ORDER BY MIN(created_at) ASC");
$months = []; $counts = [];
while($row = $trendData->fetch_assoc()) {
    $months[] = $row['month_name'];
    $counts[] = (int)$row['count'];
}

// Chart 2: Course Distribution
$courseDist = $con->query("SELECT c.coursename, count(*) as count 
    FROM admissions a 
    JOIN courses c ON a.idcourse = c.id 
    GROUP BY c.id, c.coursename 
    ORDER BY count DESC LIMIT 5");
$pieData = [];
while($row = $courseDist->fetch_assoc()) {
    $pieData[] = ['value' => (int)$row['count'], 'name' => $row['coursename']];
}

// Chart 3: Branch Performance
$branchPerf = $con->query("SELECT s.location, count(*) as count 
    FROM admissions a 
    JOIN schools s ON a.idschool = s.id 
    GROUP BY s.id, s.location 
    ORDER BY count DESC LIMIT 5");
$branchNames = []; $branchCounts = [];
while($row = $branchPerf->fetch_assoc()) {
    $branchNames[] = $row['location'];
    $branchCounts[] = (int)$row['count'];
}

// Fetch Recent Admissions
$recentAdmissions = $con->query("SELECT a.registration, s.fullname, c.coursename, a.admission_date, sch.location 
    FROM admissions a 
    JOIN students s ON a.idstudent = s.id 
    JOIN courses c ON a.idcourse = c.id 
    JOIN schools sch ON a.idschool = sch.id 
    ORDER BY a.created_at DESC LIMIT 5");

?>
<!DOCTYPE html>
<html>
<?php include('Head.php'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/echarts/5.4.2/echarts.min.js"></script>
<style>
    /* Premium Dashboard Styles */
    .dashboard-container {
        padding: 20px;
        background: #f4f6f9;
    }
    .kpi-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        border: none;
        transition: transform 0.2s;
        margin-bottom: 20px;
    }
    .kpi-card:hover { transform: translateY(-3px); }
    .kpi-card .inner { padding: 20px; color: #fff; border-radius: 10px; }
    .bg-info-premium { background: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%); }
    .bg-success-premium { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
    .bg-warning-premium { background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); }
    .bg-danger-premium { background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); }
    
    .chart-box {
        background: #fff;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        margin-bottom: 25px;
        min-height: 400px;
    }
    .data-table-card {
        background: #fff;
        border-radius: 15px;
        padding: 0;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        overflow: hidden;
    }
    .table-header {
        padding: 20px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include('topNav.php') ?>
        <?php include('sidebar.php') ?>

        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Super Admin Dashboard</h1>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    
                    <!-- KPI Row -->
                    <div class="row">
                        <div class="col-lg-3 col-6">
                            <div class="kpi-card">
                                <div class="inner bg-info-premium">
                                    <h3><?php echo number_format($totalStudents); ?></h3>
                                    <p>Total Students</p>
                                    <div class="icon"><i class="fas fa-users"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="kpi-card">
                                <div class="inner bg-success-premium">
                                    <h3><?php echo number_format($totalAdmissions); ?></h3>
                                    <p>Total Admissions</p>
                                    <div class="icon"><i class="fas fa-file-signature"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="kpi-card">
                                <div class="inner bg-warning-premium">
                                    <h3><?php echo number_format($monthlyAdmissions); ?></h3>
                                    <p>Admissions (MTD)</p>
                                    <div class="icon"><i class="fas fa-calendar-alt"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-6">
                            <div class="kpi-card">
                                <div class="inner bg-danger-premium">
                                    <h3><?php echo number_format($totalSchools); ?></h3>
                                    <p>Active Branches</p>
                                    <div class="icon"><i class="fas fa-school"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Row -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="chart-box" id="admissionTrend"></div>
                        </div>
                        <div class="col-md-4">
                            <div class="chart-box" id="courseDistribution"></div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="chart-box" id="branchPerf"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="data-table-card">
                                <div class="table-header">
                                    <h3 style="font-size: 1.1rem; margin: 0;">Recent Admissions</h3>
                                    <a href="admissionRecord.php" class="btn btn-sm btn-outline-primary">View All</a>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table table-hover mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Reg #</th>
                                                <th>Name</th>
                                                <th>Branch</th>
                                                <th>Course</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while($row = $recentAdmissions->fetch_assoc()): ?>
                                            <tr>
                                                <td><b><?php echo $row['registration']; ?></b></td>
                                                <td><?php echo $row['fullname']; ?></td>
                                                <td><span class="badge badge-info"><?php echo $row['location']; ?></span></td>
                                                <td><?php echo $row['coursename']; ?></td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        <?php include('footer.php') ?>
    </div>

    <?php include('footerPlugins.php') ?>

    <script>
        // Admission Trend Chart
        var trendChart = echarts.init(document.getElementById('admissionTrend'));
        trendChart.setOption({
            title: { text: 'Enrollment Growth (Last 6 Months)', left: 'center' },
            tooltip: { trigger: 'axis' },
            grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
            xAxis: { type: 'category', data: <?php echo json_encode($months); ?> },
            yAxis: { type: 'value' },
            series: [{
                data: <?php echo json_encode($counts); ?>,
                type: 'line',
                smooth: true,
                color: '#0ea5e9',
                areaStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                        { offset: 0, color: 'rgba(14, 165, 233, 0.4)' },
                        { offset: 1, color: 'rgba(14, 165, 233, 0)' }
                    ])
                }
            }]
        });

        // Course Distribution Chart
        var distChart = echarts.init(document.getElementById('courseDistribution'));
        distChart.setOption({
            title: { text: 'Popular Courses', left: 'center' },
            tooltip: { trigger: 'item' },
            legend: { bottom: '0' },
            series: [{
                name: 'Course',
                type: 'pie',
                radius: ['40%', '70%'],
                center: ['50%', '45%'],
                avoidLabelOverlap: false,
                itemStyle: { borderRadius: 10, borderColor: '#fff', borderWidth: 2 },
                label: { show: false },
                data: <?php echo json_encode($pieData); ?>
            }]
        });

        // Branch Performance Chart
        var branchChart = echarts.init(document.getElementById('branchPerf'));
        branchChart.setOption({
            title: { text: 'Top 5 Performing Branches', left: 'center' },
            tooltip: { trigger: 'axis' },
            grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
            xAxis: { type: 'value' },
            yAxis: { type: 'category', data: <?php echo json_encode(array_reverse($branchNames)); ?> },
            series: [{
                name: 'Admissions',
                type: 'bar',
                data: <?php echo json_encode(array_reverse($branchCounts)); ?>,
                itemStyle: { color: '#10b981', borderRadius: [0, 5, 5, 0] }
            }]
        });

        window.addEventListener('resize', function() {
            trendChart.resize();
            distChart.resize();
            branchChart.resize();
        });
    </script>
</body>
</html>
