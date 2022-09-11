
        loadreport();

        function deletecsv(file) {
            if (confirm("Are you sure to delete this file?")) {
                $("#csvtodelete").val(file);
                $("#deleteform").submit();
            }

        }

        function up() {
            $("#fileToUpload").click();
        }



        function loadreport() {
            $.post("loadreport1.php",
                function(response) {
                    var result = JSON.parse(response);
                    console.log(result);
                    $("#active").text(result[4][0]);

                    $("#recovered").text(result[4][1]);

                    $("#deceased").text(result[4][2]);
                    $("#confirmed").text(result[4][0] + result[4][1] + result[4][2]);

                
                    //overall
                    var ctx = document.getElementById('myChart').getContext('2d');

                    var labels = result[0];
                    var data = {
                        labels: labels,
                        datasets: [{
                                label: 'Active',
                                data: result[1],
                                borderColor: "rgba(0,0,255,0.5)",
                                backgroundColor: "rgba(0,0,255,0.5)",
                                borderRadius: 5
                            },

                            {
                                label: 'Recovered',
                                data: result[2],
                                borderColor: "rgba(0,255,0,0.5)",
                                backgroundColor: "rgba(0,255,0,0.5)",
                                borderRadius: 5
                            },
                            {
                                label: 'Deceased',
                                data: result[3],
                                borderColor: "rgba(255,0,0,0.5)",
                                backgroundColor: "rgba(255,0,0,0.5)",
                                borderRadius: 5
                            },
                        ]
                    };

                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: false,
                                    text: 'Cases per Campus'
                                }
                            }
                        },
                    });


                    //trend
                    var ctx = document.getElementById('myChart9').getContext('2d');

                    var labels = result[6];
                    var data = {
                        labels: labels,
                        datasets: [{
                            label: 'COVID Cases',
                            data: result[5][9],
                            borderColor: "rgba(245, 0, 0,0.8)",
                            backgroundColor: "rgba(245, 0, 0,0.8)"
                        }]
                    };

                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: false,
                                    text: ''
                                }
                            },
                            tension: 0.4
                        },
                    });


                    

                    var ctx = document.getElementById('myChart8').getContext('2d');

                    var labels = result[6];
                    var data = {
                        labels: labels,
                        datasets: [{
                            label: 'Alaminos',
                            data: result[5][0],
                            borderColor: "rgba(245, 66, 66,0.8)",
                            backgroundColor: "rgba(245, 66, 66,0.8)",
                        }, {
                            label: 'Asingan',
                            data: result[5][1],
                            borderColor: "rgba(245, 173, 66,0.8)",
                            backgroundColor: "rgba(245, 173, 66,0.8)",
                        }, {
                            label: 'Bayambang',
                            data: result[5][2],
                            borderColor: "rgba(224, 245, 66,0.8)",
                            backgroundColor: "rgba(224, 245, 66,0.8)",
                        }, {
                            label: 'Binmaley',
                            data: result[5][3],
                            borderColor: "rgba(66, 200, 245,0.8)",
                            backgroundColor: "rgba(66, 200, 245,0.8)",
                        }, {
                            label: 'Infanta',
                            data: result[5][4],
                            borderColor: "rgba(66, 90, 245,0.8)",
                            backgroundColor: "rgba(66, 90, 245,0.8)",
                        }, {
                            label: 'Lingayen',
                            data: result[5][5],
                            borderColor: "rgba(245, 66, 200,0.8)",
                            backgroundColor: "rgba(245, 66, 200,0.8)",
                        }, {
                            label: 'San Carlos',
                            data: result[5][6],
                            borderColor: "rgba(87, 150, 72,0.8)",
                            backgroundColor: "rgba(87, 150, 72,0.8)",
                        }, {
                            label: 'Sta Maria',
                            data: result[5][7],
                            borderColor: "rgba(72, 149, 150,0.8)",
                            backgroundColor: "rgba(72, 149, 150,0.8)",
                        }, {
                            label: 'Urdaneta',
                            data: result[5][8],
                            borderColor: "rgba(121, 72, 150,0.8)",
                            backgroundColor: "rgba(121, 72, 150,0.8)",
                        }]
                    };

                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                title: {
                                    display: false,
                                    text: ''
                                }
                            },
                            tension: 0.3
                        },
                    });


                        //some data

                      


                        var ctx = document.getElementById('m1').getContext('2d');

                        var labels = ["Male", "Female"];
                        var data = {
                            labels: labels,
                            datasets: [{
                                label: 'Dataset 1',
                                data: result[7][0],
                                backgroundColor: [
                                    "rgba(0, 134, 255,0.5)",
                                    "rgba(255, 0, 107,0.5)"
                                ],
                            }]
                        };
                        var myChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Sex'
                                    }
                                }
                            },
                        });
    
    
    
                        //comorbidity
    
                        var ctx = document.getElementById('m2').getContext('2d');
    
                        var labels = ["Yes", "No"];
                        var data = {
                            labels: labels,
                            datasets: [{
                                label: labels,
                                data:result[7][1],
                                backgroundColor: [
                                    "rgba(255, 125, 0,0.5)",
                                    "rgba(197, 255, 0,0.5)"
                                ],
                            }]
                        };
                        var myChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Comorbidity'
                                    }
                                }
                            },
                        });
    
    
    
                        //teaching
    
    
                        var ctx = document.getElementById('m3').getContext('2d');
    
                        var labels = ["Teaching", "Non-Teaching"];
                        var data = {
                            labels: labels,
                            datasets: [{
                                label: 'Dataset 1',
                                data: result[7][2],
                                backgroundColor: [
                                    "rgba(224, 0, 255,0.5)",
                                    "rgba(255, 170, 0,0.5)"
                                ],
                            }]
                        };
                        var myChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Teaching Status'
                                    }
                                }
                            },
                        });
    
    
                        //source
    
                        var ctx = document.getElementById('m4').getContext('2d');
    
                        var labels = ["Home", "Work", "Unknown"];
                        var data = {
                            labels: labels,
                            datasets: [{
                                label: 'Dataset 1',
                                data: result[7][3],
                                backgroundColor: [
                                    "rgba(126, 95, 16,0.5)",
                                    "rgba(16, 126, 101,0.5)",
                                    "rgba(126, 16, 97,0.5)"
                                ],
                            }]
                        };
                        var myChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Possible Source'
                                    }
                                }
                            },
                        });
    
    
    
                        //vaccination
    
                        var ctx = document.getElementById('m5').getContext('2d');
    
                        var labels = ["Unvaccinated", "Vaccinated 1st", "Fully Vaccinated"];
                        var data = {
                            labels: labels,
                            datasets: [{
                                label: 'Dataset 1',
                                data: result[7][4],
                                backgroundColor: [
                                    "rgba(216, 118, 120,0.8)",
                                    "rgba(159, 118, 216,0.8)",
                                    "rgba(146, 216, 118,0.8)"
                                ],
                            }]
                        };
                        var myChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    },
                                    title: {
                                        display: true,
                                        text: 'Vaccination Status'
                                    }
                                }
                            },
                        });
    
    
    
                    //age group
                    var ctx = document.getElementById('m6').getContext('2d');
                    // 25 - 29
                    // 30 - 34
                    // 35 - 39
                    // 40 - 44
                    // 45 - 49
                    // 50 - 54
                    // 55 - 59
                    // 60 - 64
                    var labels = ["20-24", "25-29", "30-34", "35-39", "40-44", "45-49", "50-54", "55-59", "60-64", "N/A"];
                    var data = {
                        labels: labels,
                        datasets: [{
                            label: 'Cases',
                            data: result[7][5],
                            backgroundColor: [
                                "rgba(66, 200, 29,0.8)",
                                "rgba(128, 210, 106,0.8)",
                                "rgba(162, 204, 152,0.8)",
                            ],
                            borderRadius: 5
                        }]
                    };
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'Age Group'
                                }
                            }
                        },
                    });
                      
    

                });







            loadmeta();





        }


        function loadmeta() {
            $("#meta11").html($("#meta11").html());
            $("#meta22").html($("#meta22").html());
            var getname = $("#campusname").val();
            $.post("loadreport2.php", {
                    campus_name: getname
                },
                function(response) {
                    var result = JSON.parse(response);


                    console.log(result);

                    $("#active1").text(result[5][0]);

                    $("#recovered1").text(result[5][1]);

                    $("#deceased1").text(result[5][2]);
                    $("#confirmed1").text(result[5][0] + result[5][1] + result[5][2]);
                    //sex

                    var ctx = document.getElementById('myChart1').getContext('2d');

                    var labels = ["Male", "Female"];
                    var data = {
                        labels: labels,
                        datasets: [{
                            label: 'Dataset 1',
                            data: result[0],
                            backgroundColor: [
                                "rgba(0, 134, 255,0.5)",
                                "rgba(255, 0, 107,0.5)"
                            ],
                        }]
                    };
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'Sex'
                                }
                            }
                        },
                    });



                    //comorbidity

                    var ctx = document.getElementById('myChart2').getContext('2d');

                    var labels = ["Yes", "No"];
                    var data = {
                        labels: labels,
                        datasets: [{
                            label: labels,
                            data: result[1],
                            backgroundColor: [
                                "rgba(255, 125, 0,0.5)",
                                "rgba(197, 255, 0,0.5)"
                            ],
                        }]
                    };
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'Comorbidity'
                                }
                            }
                        },
                    });



                    //teaching


                    var ctx = document.getElementById('myChart3').getContext('2d');

                    var labels = ["Teaching", "Non-Teaching"];
                    var data = {
                        labels: labels,
                        datasets: [{
                            label: 'Dataset 1',
                            data: result[2],
                            backgroundColor: [
                                "rgba(224, 0, 255,0.5)",
                                "rgba(255, 170, 0,0.5)"
                            ],
                        }]
                    };
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'Teaching Status'
                                }
                            }
                        },
                    });


                    //source

                    var ctx = document.getElementById('myChart4').getContext('2d');

                    var labels = ["Home", "Work", "Unknown"];
                    var data = {
                        labels: labels,
                        datasets: [{
                            label: 'Dataset 1',
                            data: result[3],
                            backgroundColor: [
                                "rgba(126, 95, 16,0.5)",
                                "rgba(16, 126, 101,0.5)",
                                "rgba(126, 16, 97,0.5)"
                            ],
                        }]
                    };
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'Possible Source'
                                }
                            }
                        },
                    });



                    //vaccination

                    var ctx = document.getElementById('myChart5').getContext('2d');

                    var labels = ["Unvaccinated", "Vaccinated 1st", "Fully Vaccinated"];
                    var data = {
                        labels: labels,
                        datasets: [{
                            label: 'Dataset 1',
                            data: result[4],
                            backgroundColor: [
                                "rgba(216, 118, 120,0.8)",
                                "rgba(159, 118, 216,0.8)",
                                "rgba(146, 216, 118,0.8)"
                            ],
                        }]
                    };
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'Vaccination Status'
                                }
                            }
                        },
                    });



                    //campus case

                    var ctx = document.getElementById('myChart6').getContext('2d');

                    var labels = ["Active", "Recovered", "Deceased"];
                    var data = {
                        labels: labels,
                        datasets: [{
                            label: 'Dataset 1',
                            data: result[5],
                            backgroundColor: [
                                "rgba(0, 0, 255,0.5)",
                                "rgba(0, 255, 0,0.5)",
                                "rgba(255, 0, 0,0.5)"
                            ],
                        }]
                    };
                    var myChart = new Chart(ctx, {
                        type: 'doughnut',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'COVID Cases'
                                }
                            }
                        },
                    });



                    //age group
                    var ctx = document.getElementById('myChart7').getContext('2d');
                    // 25 - 29
                    // 30 - 34
                    // 35 - 39
                    // 40 - 44
                    // 45 - 49
                    // 50 - 54
                    // 55 - 59
                    // 60 - 64
                    var labels = ["20-24","25-29", "30-34", "35-39", "40-44", "45-49", "50-54", "55-59", "60-64", "N/A"];
                    var data = {
                        labels: labels,
                        datasets: [{
                            label: 'Cases',
                            data: result[6],
                            backgroundColor: [
                                "rgba(66, 200, 29,0.8)",
                                "rgba(128, 210, 106,0.8)",
                                "rgba(162, 204, 152,0.8)",
                            ],
                            borderRadius: 5
                        }]
                    };
                    var myChart = new Chart(ctx, {
                        type: 'bar',
                        data: data,
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                },
                                title: {
                                    display: true,
                                    text: 'Age Group'
                                }
                            }
                        },
                    });

                        //trend
                        var ctx = document.getElementById('m7').getContext('2d');

                        var labels = result[7][0];
                        var data = {
                            labels: labels,
                            datasets: [{
                                label: 'Cases',
                                data: result[7][1],
                                borderColor: "rgba(245, 0, 0,0.8)",
                                backgroundColor: "rgba(245, 0, 0,0.8)"
                            }]
                        };
    
                        var myChart = new Chart(ctx, {
                            type: 'line',
                            data: data,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    title: {
                                        display: false,
                                        text: ''
                                    }
                                },
                                tension: 0.4
                            },
                        });


                });
        }