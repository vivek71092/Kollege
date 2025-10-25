/* /public/js/admin.js */

/*
 * Kollege LMS - Admin JavaScript
 * ------------------------------
 * This file contains scripts *only* for the Admin panel.
 * It's loaded after dashboard.js.
 * * Assumes libraries like jQuery, DataTables, and Chart.js
 * have been included on the admin pages that need them.
 */

document.addEventListener("DOMContentLoaded", function() {

    /**
     * Initialize DataTables
     * ---------------------
     * This turns any HTML table with the class .data-table
     * into a powerful, sortable, searchable table.
     *
     * REQUIRES: jQuery and DataTables JS/CSS libraries.
     */
    function initDataTables() {
        // Check if jQuery and DataTables are loaded
        if (typeof jQuery !== 'undefined' && typeof jQuery.fn.DataTable !== 'undefined') {
            
            // Initialize all tables with the class 'data-table'
            $('.data-table').each(function() {
                $(this).DataTable({
                    responsive: true,
                    pagingType: "simple_numbers",
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search records..."
                    }
                });
            });

        } else {
            console.warn('jQuery or DataTables is not loaded. Skipping table initialization.');
        }
    }

    /**
     * Initialize Chart.js
     * -------------------
     * This example creates a simple bar chart on the admin
     * analytics dashboard.
     *
     * REQUIRES: Chart.js library.
     */
    function initAnalyticsCharts() {
        // Check if Chart.js is loaded
        if (typeof Chart !== 'undefined') {
            
            // Example: User Enrollment Chart
            const enrollmentChartCanvas = document.getElementById('enrollmentChart');
            if (enrollmentChartCanvas) {
                const ctx = enrollmentChartCanvas.getContext('2d');
                
                // You would fetch this data via AJAX
                const chartData = {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'New Students',
                        data: [12, 19, 3, 5, 2, 3], // Example data
                        backgroundColor: 'rgba(13, 110, 253, 0.6)',
                        borderColor: 'rgba(13, 110, 253, 1)',
                        borderWidth: 1
                    }]
                };

                new Chart(ctx, {
                    type: 'bar',
                    data: chartData,
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: true,
                                text: 'Monthly Student Signups'
                            }
                        }
                    }
                });
            }
        
        } else {
            console.warn('Chart.js is not loaded. Skipping chart initialization.');
        }
    }

    // Initialize all admin-specific scripts
    initDataTables();
    initAnalyticsCharts();

    // Add more admin-only scripts here...
    // e.g., logic for bulk user actions, system settings forms, etc.

});