Morris.Bar({
  element: 'graph',
  data: [
    {x: 'January', y: 0},
    {x: 'February', y: 1},
    {x: 'March', y: 2},
    {x: 'April', y: 3},
    {x: 'May', y: 4},
    {x: 'Jun', y: 5},
    {x: 'July', y: 6},
    {x: 'August', y: 7},
    {x: 'September', y: 8},
	{x: 'October', y: 8},
	{x: 'November', y: 8},
	{x: 'December', y: 8}
  ],
  xkey: 'x',
  ykeys: ['y'],
  labels: ['Y'],
  barColors: function (row, series, type) {
    if (type === 'bar') {
      var red = Math.ceil(255 * row.y / this.ymax);
      return 'rgb(' + red + ',0,0)';
    }
    else {
      return '#000';
    }
  }
});