<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<link href='../fullcalendar.min.css' rel='stylesheet' />
<link href='../fullcalendar.print.min.css' rel='stylesheet' media='print' />
<script src='../lib/moment.min.js'></script>
<script src='../lib/jquery.min.js'></script>
<script src='../fullcalendar.min.js'></script>
<script src='../locale/es.js'></script>
<script>
var calendarData = [];
  $(document).ready(function() {
    $.ajax({
        url:   'ajax/ajax_eventos.php',
        type:"POST",
        dataType:"json",
        success:  function (data) {
          calendarData=data;
          printCalendar();
        }
    });    


    function printCalendar () {
      $('#calendar').fullCalendar({
      header: {

        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
      },
      defaultDate: moment(),
      lang:'es',
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      eventLimit: true, // allow "more" link when too many events
      events: calendarData,
      eventClick: function(calEvent, jsEvent, view) {
        window.open(calEvent.link);
      }
      });
    }

  });

</script>
<style>

  body {
    margin: 40px 10px;
    padding: 0;
    font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
    font-size: 14px;
  }

  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }

</style>
</head>
<body>
  <div id='calendar'></div>
</body>
</html>
