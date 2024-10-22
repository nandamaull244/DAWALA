var optionsProfileVisit = {
	annotations: {
		position: 'back'
	},
	dataLabels: {
		enabled: false
	},
	chart: {
		type: 'bar',
		height: 300,
		scrollX: true
	},
	fill: {
		opacity: 1
	},
	plotOptions: {
		bar: {
			horizontal: false,
			columnWidth: '55%',
			endingShape: 'rounded'
		},
	},
	series: [{
		name: 'Progress Penyelesaian',
		data: [65, 59, 80, 81, 56, 55, 40, 70, 75, 67, 72, 78, 69, 74, 77, 82, 63, 58, 71, 76, 79, 68, 73, 66, 61, 64, 83, 85, 60, 62, 84, 57]
	}],
	colors: '#435ebe',
	xaxis: {
		categories: ["Kec. 1", "Kec. 2", "Kec. 3", "Kec. 4", "Kec. 5", "Kec. 6", "Kec. 7", "Kec. 8", "Kec. 9", "Kec. 10", "Kec. 11", "Kec. 12", "Kec. 13", "Kec. 14", "Kec. 15", "Kec. 16", "Kec. 17", "Kec. 18", "Kec. 19", "Kec. 20", "Kec. 21", "Kec. 22", "Kec. 23", "Kec. 24", "Kec. 25", "Kec. 26", "Kec. 27", "Kec. 28", "Kec. 29", "Kec. 30", "Kec. 31", "Kec. 32"],
		tickPlacement: 'on',
		labels: {
			rotate: -45,
			rotateAlways: true,
			style: {
				fontSize: '12px'
			}
		}
	},
	yaxis: {
		title: {
			text: 'Progress (%)'
		}
	},
	tooltip: {
		y: {
			formatter: function (val) {
				return val + "%"
			}
		}
	}
}
let optionsVisitorsProfile  = {
	series: [20, 15, 25, 18, 12, 10],
	labels: ['disabilitas', 'ODGJ','Lansia','Penduduk sakit','Penduduk terlantar','terdampak bencana'],
	colors: ['#435ebe','#55c6e8'],
	chart: {
		type: 'donut',
		width: '100%',
		height:'350px'
	},
	legend: {
		position: 'bottom'
	},
	plotOptions: {
		pie: {
			donut: {
				size: '30%'
			}
		}
	}
}

var optionsEurope = {
	series: [{
		name: 'series1',
		data: [310, 800, 600, 430, 540, 340, 605, 805,430, 540, 340, 605]
	}],
	chart: {
		height: 80,
		type: 'area',
		toolbar: {
			show:false,
		},
	},
	colors: ['#5350e9'],
	stroke: {
		width: 2,
	},
	grid: {
		show:false,
	},
	dataLabels: {
		enabled: false
	},
	xaxis: {
		type: 'datetime',
		categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z","2018-09-19T07:30:00.000Z","2018-09-19T08:30:00.000Z","2018-09-19T09:30:00.000Z","2018-09-19T10:30:00.000Z","2018-09-19T11:30:00.000Z"],
		axisBorder: {
			show:false
		},
		axisTicks: {
			show:false
		},
		labels: {
			show:false,
		}
	},
	show:false,
	yaxis: {
		labels: {
			show:false,
		},
	},
	tooltip: {
		x: {
			format: 'dd/MM/yy HH:mm'
		},
	},
};

let optionsAmerica = {
	...optionsEurope,
	colors: ['#008b75'],
}
let optionsIndonesia = {
	...optionsEurope,
	colors: ['#dc3545'],
}



var chartProfileVisit = new ApexCharts(document.querySelector("#chart-profile-visit"), optionsProfileVisit);
var chartVisitorsProfile = new ApexCharts(document.getElementById('chart-visitors-profile'), optionsVisitorsProfile)
var chartEurope = new ApexCharts(document.querySelector("#chart-europe"), optionsEurope);
var chartAmerica = new ApexCharts(document.querySelector("#chart-america"), optionsAmerica);
var chartIndonesia = new ApexCharts(document.querySelector("#chart-indonesia"), optionsIndonesia);

chartIndonesia.render();
chartAmerica.render();
chartEurope.render();
chartProfileVisit.render();
chartVisitorsProfile.render()