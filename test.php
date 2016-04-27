<html>

   <head>
      <title>The jQuery Example</title>
	  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
      
		
      <script type = "text/javascript" language = "javascript">
         $(document).ready(function() {
            $("#driver").click(function(event){
               var name = $("#name").val();
               $("#stage").load('test2.php', {"name":name} );
            });
         });
      </script>
   </head>
	
   <body>
	
      <p>Enter your name and click on the button:</p>
      <input type = "input" id = "name" size = "40" /><br />
		
      <div id = "stage" style = "background-color:cc0;">
         STAGE
      </div>
		
      <input type = "button" id = "driver" value = "Show Result" />
		
   </body>
	
</html>