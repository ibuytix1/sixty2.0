(function($) {
    "use strict"

    $('#attend_event_1').circleProgress({
        // startAngle: -Math.PI / 4 * 3,
        thickness: '7',
        value: 0.3,
        size: 145,
        lineCap: 'round',
        fill: { color: 'rgba(105, 27, 204,1)' },
        reverse: false
    });
    $('#attend_event_2').circleProgress({
        // startAngle: -Math.PI / 4 * 3,
        thickness: '7',
        value: 0.5,
        size: 145,
        lineCap: 'round',
        fill: { color: 'rgba(40, 199, 111,1)' },
        reverse: false
    });
    $('#attend_event_3').circleProgress({
        // startAngle: -Math.PI / 4 * 3,
        thickness: '7',
        value: 0.8,
        size: 145,
        lineCap: 'round',
        fill: { color: 'rgba(61, 68, 101,1)' },
        reverse: false
    });
    // $('#attend_event_4').circleProgress({
    //     // startAngle: -Math.PI / 4 * 3,
    //     value: 0.9,
    //     size: 145,
    //     lineCap: 'round',
    //     fill: { color: 'rgba(105, 27, 204,1)' },
    //     reverse: false
    // });

    
    const chart_widget_1 = document.getElementById("chart_widget_1").getContext('2d');

    new Chart(chart_widget_1, {
        type: "line",
        data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [{
                label: "Sales Stats",
                backgroundColor: "rgba(255, 255, 255, 0.2)",
                borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth: 2,               
                data: [0, 18, 14, 24, 16, 30]
            }]
        },
        
        options: {
            title: {
                display: !1
            },
            tooltips: {
                intersect: !1,
                mode: "nearest",
                xPadding: 5,
                yPadding: 5,
                caretPadding: 5
            },
            legend: {
                display: !1
            },
            responsive: !0,
            maintainAspectRatio: !1,
            hover: {
                mode: "index"
            },
            scales: {
                xAxes: [{
                    display: !1,
                    gridLines: !1,
                    scaleLabel: {
                        display: !0,
                        labelString: "Month"
                    }, 
                    ticks: {
                        max: 30, 
                        min: 0
                    }
                }],
                yAxes: [{
                    display: !1,
                    gridLines: !1,
                    scaleLabel: {
                        display: !0,
                        labelString: "Value"
                    },
                    ticks: {
                        beginAtZero: !0
                    }
                }]
            },
            elements: {
                // line: {
                //     tension: 5
                // },
                point: {
                    radius: 0,
                    borderWidth: 0
                }
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            }
        }
    });

    
	
    const chart_widget_3 = document.getElementById("chart_widget_3").getContext('2d');

    new Chart(chart_widget_3, {
        type: "line",
        data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [{
                label: "Sales Stats",
                backgroundColor: "rgba(255, 255, 255, 0.2)",
                borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth: 2,              
                data: [0, 18, 14, 24, 16, 30]
            }]
        },
        
        options: {
            title: {
                display: !1
            },
            tooltips: {
                intersect: !1,
                mode: "nearest",
                xPadding: 5,
                yPadding: 5,
                caretPadding: 5
            },
            legend: {
                display: !1
            },
            responsive: !0,
            maintainAspectRatio: !1,
            hover: {
                mode: "index"
            },
            scales: {
                xAxes: [{
                    display: !1,
                    gridLines: !1,
                    scaleLabel: {
                        display: !0,
                        labelString: "Month"
                    }, 
                    ticks: {
                        max: 30, 
                        min: 0
                    }
                }],
                yAxes: [{
                    display: !1,
                    gridLines: !1,
                    scaleLabel: {
                        display: !0,
                        labelString: "Value"
                    },
                    ticks: {
                        beginAtZero: !0
                    }
                }]
            },
            elements: {
                // line: {
                //     tension: 5
                // },
                point: {
                    radius: 0,
                    borderWidth: 0
                }
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            }
        }
    });

    
    const chart_widget_04 = document.getElementById("chart_widget_04").getContext('2d');

    new Chart(chart_widget_04, {
        type: "line",
        data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [{
                label: "Sales Stats",
                backgroundColor: "rgba(255, 255, 255, .2)",
                borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth:2,
                // lineTension: 0,
	            // pointRadius: 4,
                // pointBorderWidth: 2,
                // pointBackgroundColor: 'rgba(105, 27, 204, 1)',
                // pointBorderColor: 'rgba(105, 27, 204, 1)',
                // pointHoverBackgroundColor: 'rgba(105, 27, 204, 1)',
                // pointHoverBorderColor: 'rgba(105, 27, 204, 1)',
                data: [0, 18, 14, 24, 16, 30]
            }]
        },
        options: {
            title: {
                display: !1
            },
            tooltips: {
                intersect: !1,
                mode: "nearest",
                xPadding: 5,
                yPadding: 5,
                caretPadding: 5
            },
            legend: {
                display: !1
            },
            responsive: !0,
            maintainAspectRatio: !1,
            hover: {
                mode: "index"
            },
            scales: {
                xAxes: [{
                    display: !1,
                    gridLines: !1,
                    scaleLabel: {
                        display: !0,
                        labelString: "Month"
                    }, 
                    ticks: {
                        max: 30, 
                        min: 0
                    }
                }],
                yAxes: [{
                    display: !1,
                    gridLines: !1,
                    scaleLabel: {
                        display: !0,
                        labelString: "Value"
                    },
                    ticks: {
                        beginAtZero: !0
                    }
                }]
            },
            elements: {
                // line: {
                //     tension: 0.2
                // },
                point: {
                    radius: 0,
                    borderWidth: 0
                }
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            }
        }
    });


    
    const chart_widget_2 = document.getElementById("chart_widget_2").getContext('2d');

    new Chart(chart_widget_2, {
        type: "line",
        data: {
            labels: ["January", "February", "March", "April", "May", "June"],
            datasets: [{
                label: "Sales Stats",
                backgroundColor: "rgba(255, 255, 255, 0.1)",
                borderColor: 'rgba(255, 255, 255, 1)',
                borderWidth:2,
                // pointBackgroundColor: 'rgba(105, 27, 204, 1)',
                // pointBorderColor: 'rgba(105, 27, 204, 1)',
                // pointHoverBackgroundColor: 'rgba(105, 27, 204, 1)',
                // pointHoverBorderColor: 'rgba(105, 27, 204, 1)',
                data: [0, 18, 14, 24, 16, 30]
            }]
        },
        options: {
            title: {
                display: !1
            },
            tooltips: {
                intersect: !1,
                mode: "nearest",
                xPadding: 5,
                yPadding: 5,
                caretPadding: 5
            },
            legend: {
                display: !1
            },
            responsive: !0,
            maintainAspectRatio: !1,
            hover: {
                mode: "index"
            },
            scales: {
                xAxes: [{
                    display: !1,
                    gridLines: !1,
                    scaleLabel: {
                        display: !0,
                        labelString: "Month"
                    }, 
                    ticks: {
                        max: 30, 
                        min: 0
                    }
                }],
                yAxes: [{
                    display: !1,
                    gridLines: !1,
                    scaleLabel: {
                        display: !0,
                        labelString: "Value"
                    },
                    ticks: {
                        beginAtZero: !0
                    }
                }]
            },
            elements: {
                line: {
                    // tension: 0
                },
                point: {
                    radius: 0,
                    borderWidth: 1
                }
            },
            layout: {
                padding: {
                    left: 0,
                    right: 0,
                    top: 0,
                    bottom: 0
                }
            }
        }
    });



    //bar chart

   //bar chart
   Morris.Bar({
    element: 'sales_overview',
    data: [{
        y: 'Jan',
        a: 100,
        b: 90,
        c: 60
    }, {
        y: 'Feb',
        a: 75,
        b: 65,
        c: 40
    }, {
        y: 'Mar',
        a: 50,
        b: 40,
        c: 30
    }, {
        y: 'Apr',
        a: 75,
        b: 65,
        c: 40
    }, {
        y: 'May',
        a: 50,
        b: 40,
        c: 30
    }, {
        y: 'Jun',
        a: 75,
        b: 65,
        c: 40
    }, {
        y: 'Jul',
        a: 100,
        b: 90,
        c: 40
    }],
    xkey: 'y',
    ykeys: ['a', 'b', 'c'],
    labels: ['Ticket 1', 'Ticket 2', 'Ticket 3'],
    barColors: ['#6A1CCD', '#3D4465', '#28C76F'],
    hideHover: 'auto',
    gridLineColor: 'transparent',
    resize: true,
    barSizeRatio: 0.25,
});
        

})(jQuery);