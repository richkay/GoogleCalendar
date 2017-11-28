<!DOCTYPE html>
<html>
<head>
	<title>Public Holidays -  Indonesia</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.min.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">


	
	<style type="text/css">

		.fc-sun{ 
		    color:#FFF; 
		    background: red;
		}

		.lh{

			cursor: pointer;
		}

	</style>

</head>
<body>

	<div class="container-fluid">

        <div class="row">
        		
        		<div class="col-md-3">
        			<button 
        				class="btn btn-sm" 
        				style="margin-top: 4px;cursor: pointer;"
        				data-toggle="modal" data-target="#calModal"
        				>

        				Add New Event

        			</button>

        			<hr>

        			<ul id="lsholiday"></ul>

        		</div>

        		<div class="col-md-9">
        				
        				<div class="content">
        					
        					<h3>Public Holidays</h3>
        					<hr>

        					<div class="main">
        						
        						<div id="calendar"></div>

        					</div>

        				</div>

        		</div>	
        </div>

    </div>

    <!--- Modal Tag -->
   <div class="modal fade" id="calModal" role="dialog">

    	<div class="modal-dialog">
    
	      <div class="modal-content">

		        <div class="modal-header">

		          <h4 class="modal-title">Add New Event</h4>

		        </div>

		        <div class="modal-body">

		        	<div class="form-group">

					  <label for="titleEvent">Title:</label>

					  <input type="text" class="form-control" name="titleEvent" id="titleEvent">

					</div> 

					<div class="form-group">

					  <label for="startEvent">Start Date:</label>

					  <input type="text" class="form-control" name="startEvent" id="startEvent"  data-date-format="yyyy-mm-dd">

					</div> 

		        </div>

		        <div class="modal-footer">

		        	<button id="addEv"  type="button" class="btn btn-primary" >Process</button>

		          	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

		        </div>

	    	</div>

    	</div>

  	</div>
  <!--- End Modal Tag -->


    <script src="https://code.jquery.com/jquery-3.2.1.min.js" ></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/moment.min.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/locale/id.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>



	<script>
		var listholiday;

		function addEvent(title,start,description) {

			var data;

			data = {
				'title' :title,
				'start' :start,
				'description' :description,
				'color' :'red',
				'textColor' :'#FFF'
			}

			listholiday.push(data);
			array_sort_by_column();

			$('#calendar').fullCalendar('addEventSource', [data]);

			$("#calModal").modal('hide');
		}

	
		function getDefaultHoliday(){

			$.ajaxSetup({async:false});

			$.get( "/listholiday",function(r) {
			  
			  listholiday = r;

			});

		}

		function gotoDate(date){
			$('#calendar').fullCalendar( 'gotoDate', moment(date) )
		}


		function addDefaultHoliday(){

			for (var i = 0; i < listholiday.length; i++) {

				$('#lsholiday').append('<li class="lh" data-date="'+listholiday[i].start+'">'+listholiday[i].start+' - '+listholiday[i].title+'</li>')

			}

		}

		function array_sort_by_column() {

		    listholiday.sort(function(a,b){

				var c = new Date(a.start);

				var d = new Date(b.start);

				return c-d;

			});

		}

		function renderCal(){

			$('#calendar').fullCalendar({

		        defaultDate: moment('2018-01-01'),

		        lang: 'id',

		        header:{
				    left:'title',
				    center:'',
				    right:'prev,next'
				},

				events:listholiday,

				eventRender: function (event, element) {

					var eventStart = moment(event.start);

				    var eventEnd = event._end === null ? eventStart : moment(event.end);

				    var diffInDays = eventEnd.diff(eventStart, 'days');

				    $("td[data-date='" + eventStart.format('YYYY-MM-DD') + "']").css('background-color','red');

				    for(var i = 1; i < diffInDays; i++) {

				        eventStart.add(1,'day');

				        $("td[data-date='" + eventStart.format('YYYY-MM-DD') + "']").css('background-color','red');

				    }

				},

		    });

		}


		$(document).ready(function() {

			getDefaultHoliday();

			addDefaultHoliday();

			renderCal();	

			$('#startEvent').datepicker({
			});	 

			 

		});


		$('#addEv').on('click',function(){
			var title,start,description;

			$('.lh').remove();

			title = $('#titleEvent').val();
			start = $('#startEvent').val();
			description = ''
			
			addEvent(title,start,description);

			 $('#titleEvent').val('');
			 $('#startEvent').val('');

			addDefaultHoliday();
		
		}); 

	</script>

</body>
</html>