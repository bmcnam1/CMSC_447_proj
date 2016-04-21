<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>SlickGrid example 1: Basic grid</title>
  <link rel="stylesheet" href="./lib/SlickGrid/slick.grid.css" type="text/css"/>
  <link rel="stylesheet" href="./lib/SlickGrid/css/smoothness/jquery-ui-1.8.16.custom.css" type="text/css"/>
  <link rel="stylesheet" href="examples.css" type="text/css"/>
</head>
<body>
<p id="dataDiv" hidden></p>
<table width="100%">
  <tr>
    <td valign="top" width="50%">
      <div id="myGrid" style="width:100%;height:600px;"></div>
    </td>
  </tr>
</table>

<script src="./lib/SlickGrid/lib/jquery-1.7.min.js"></script>
<script src="./lib/SlickGrid/lib/jquery.event.drag-2.2.js"></script>
<script src="./lib/SlickGrid/lib/jquery-ui-1.8.16.custom.min.js"></script>

<script src="./lib/SlickGrid/slick.core.js"></script>
<script src="./lib/SlickGrid/slick.grid.js"></script>

<script>
  // get data in JSON string format
  var table_data;
  var jsonData = $.ajax({
    url: "Data.php",
	contentType: "application/json",

    async: false,
    success: function(data){

      table_data = data;
      table();
    }
  });
 


  function table() {
     ///Clean up the JSON string from Data.php
  table_data = table_data.replace("In data.php", "");
  table_data = table_data.substring(0, table_data.indexOf(']')+1);
  // create data json array
  var JSONData = JSON.parse(table_data);
  for (var i in JSONData){
    // testing for data rows
    //var name = JSONData[i]['crimeType'];
  }

  var grid;
  var columns = [
    {id: "id", name: "id", field: "id"},
    {id: "crimeDateTime", name: "crimeDateTime", field: "crimeDateTime"},
    {id: "streetName", name: "streetName", field: "streetName"},
    {id: "crimeType", name: "crimeType", field: "crimeType"},
    {id: "weapon", name: "weapon", field: "weapon"},
    {id: "district", name: "district", field: "district"},
    {id: "neighborhood", name: "neighborhood", field: "neighborhood"},
    {id: "latitude", name: "latitude", field: "latitude"},
    {id: "longitude", name: "longitude", field: "longitude"},
  ];

  var options = {
    enableCellNavigation: true,
    enableColumnReorder: false,
    forceFitColumns: true,
    multiColumnSort: true
  };
    grid = new Slick.Grid("#myGrid", JSONData, columns, options);

    // TODO get sorting working
    grid.onSort.subscribe(function (e, args) {
      var cols = args.sortCols;
      JSONData.sort(function (dataRow1, dataRow2) {
        for (var i = 0, l = cols.length; i < l; i++) {
          var field = cols[i].sortCol.field;
          var sign = cols[i].sortAsc ? 1 : -1;
          var value1 = dataRow1[field], value2 = dataRow2[field];
          var result = (value1 == value2 ? 0 : (value1 > value2 ? 1 : -1)) * sign;
          if (result != 0) {
            return result;
          }
        }
        return 0;
      });
      grid.invalidate();
      grid.render();
    });
  }

</script>
</body>
</html>