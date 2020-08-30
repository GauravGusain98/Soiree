/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

const { each } = require('jquery');

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	        }
});

$(document).ready(function(){
    var eventCount=0;

    $('#admin-login-btn').click(function(){
        $("#admin-register").css({'display':'none'});
        $("#admin-login").css({'display':'block','margin-top': '3rem', 'animation':'admin-slide 1s'});
    })
    
    $('#admin-register-btn').click(function(){
        $("#admin-login").css({'display':'none'});
        $("#admin-register").css({'display':'block', 'margin-top': '3rem', 'animation':'admin-slide 0.7s'});
    })

   $("#show-requests-btn").click(function(e){
       e.preventDefault();
       $("#cancelled-requests-table").css({'display':'none'});
       $("#guests-table").css({'display':'none'});
       $("#add-function-container").css({'display':"none"});
       $("#requests-table").css({'display':'block'});
       $.ajax({
        url: "/requests",
        type: "post",
        success: function(data){
            var Table= document.getElementById("table-data");
            while (Table.firstChild) {      //use to clear the table data
                Table.removeChild(Table.lastChild);
              }
            var i=0;
            data.forEach(function(item){
                var row=Table.insertRow(i);
                row.insertCell(0).innerHTML=++i;
                row.insertCell(1).innerHTML=item['name'];
                row.insertCell(2).innerHTML=item['email'];
                row.insertCell(3).innerHTML=item['phone'];
                row.insertCell(4).innerHTML=item['message'];
                row.insertCell(5).innerHTML='<a href="" '+ "name='"+ (i-1)+"'" + ' class="guest-status-btn text-primary fas fa-check-square"></a> | ' + '<a href="" ' + "name='"+ (i-1)+"'" + ' class="guest-status-btn text-danger fas fa-times"></a>';
            });
        }
       });
    }); 

    $("#show-guests-btn").click(function(e){
        e.preventDefault();
        $("#cancelled-requests-table").css({'display':'none'});
        $("#requests-table").css({'display':'none'});
        $("#add-function-container").css({'display':"none"});
        $("#guests-table").css({'display':'block'});
        $.ajax({
         url: "/guests",
         type: "post",
         success: function(data){
             var Table= document.getElementById("guests-data");
             while (Table.firstChild) {      //use to clear the table data
                 Table.removeChild(Table.lastChild);
               }
             console.log(Table);
             var i=0;
             data.forEach(function(item){
                 var row=Table.insertRow(i);
                 row.insertCell(0).innerHTML=++i;
                 row.insertCell(1).innerHTML=item['name'];
                 row.insertCell(2).innerHTML=item['email'];
                 row.insertCell(3).innerHTML=item['phone'];
                });
            }
        });
     }); 

    $(document).on("click",".guest-status-btn",function(e){
        e.preventDefault();
        var Table= document.getElementById("table-data");
        var num = this.name;
        var email= (Table.rows[num].cells['2'].innerHTML);
        var name= (Table.rows[num].cells['1'].innerHTML);
        var status="";
        if($(this).hasClass("fa-check-square")){
            status = "approve";
        }
        else if($(this).hasClass('fa-times')){
           status = "disapprove";   
        }

        $.ajax({
            url: "/status",
            type: "post",
            data: { 'value': status, 'email': email, "name": name},
            success: function(response){
                console.log(response);
                Table.rows[num].cells['5'].innerHTML=response;
                if(response.trim() == 'approved'){
                    Table.rows[num].cells['5'].style.cssText="color:Green;";
                }
                else{
                    Table.rows[num].cells['5'].style.cssText="color:Red;";
                }
            }
        });
        
    });

    $("#show-cancelled-btn").click(function(e){
        e.preventDefault();
        $("#requests-table").css({'display':'none'});
        $("#guests-table").css({'display':'none'});
        $("#add-function-container").css({'display':"none"});
        $("#cancelled-requests-table").css({'display':'block'});
        $.ajax({
         url: "/cancelled",
         type: "post",
         success: function(data){
             var Table= document.getElementById("cancelled-requests-data");
             while (Table.firstChild) {      //use to clear the table data
                 Table.removeChild(Table.lastChild);
               }
             console.log(Table);
             var i=0;
             data.forEach(function(item){
                 var row=Table.insertRow(i);
                 row.insertCell(0).innerHTML=++i;
                 row.insertCell(1).innerHTML=item['name'];
                 row.insertCell(2).innerHTML=item['email'];
                 row.insertCell(3).innerHTML=item['phone'];
                 row.insertCell(4).innerHTML=item['message'];
                 row.insertCell(5).innerHTML='<button ' + "name='"+ (i-1)+"'" + ' id="change-status" class="btn btn-danger btn-sm">Change</button>';
                 Table.rows[i-1].cells[5].align="center";
                });
            }
        });
     }); 

     $(document).on("click","#change-status",function(e){
        e.preventDefault();
        var Table= document.getElementById("cancelled-requests-data");
        var num = this.name;
        var email= (Table.rows[num].cells['2'].innerHTML);
        var name= (Table.rows[num].cells['1'].innerHTML);
        $.ajax({
            url: "/changestatus",
            type: "post",
            data: {'email': email, "name": name},
            success: function(response){
                console.log(response);
                Table.rows[num].cells['5'].innerHTML=response;
                Table.rows[num].cells['5'].style.cssText="color:Green;";
            }
        });
        
    });

    $("#show-add-function-btn").click(function(e){
        eventCount = 0;
        e.preventDefault();
        $("#requests-table").css({'display':'none'});
        $("#guests-table").css({'display':'none'});
        $("#cancelled-requests-table").css({'display':'none'});
        $("#add-function-container").css({'display':"block"});
    })

    function functionError(){
        var error = 0;
        if(eventCount!=0)
        {
            var eventName =document.getElementsByName("event-"+eventCount)[0].value;
            var eventTime =document.getElementsByName("event-time-"+eventCount)[0].value;
            if(eventName == "" || eventTime == "")
                error = 1;
        }
        else if(eventCount==0){
            if($("[name=function-name]").val()=="" || $("[name=function-date]").val()=="" || $("[name=function-time]").val()=="")
                error = 1;
        }
        return error;
    }

    $(document).on('click',"#add-event-btn",function(e){
        e.preventDefault();    
        var error = functionError();
        if(error > 0)
            $("#error").css({'display': "block"});
        else{
            eventCount++;
            $("#error").css({'display': "none"});
            $("#add-function").append("<div name='eventname"+eventCount+"'"+" class='form-group'><label> Event"+ eventCount +" </label> "+ '<a href="" '+ "name='"+ eventCount +"'" + ' class=" event-cancel text-danger fas fa-times ml-3"></a>' +" <input name='event-"+eventCount+"' class='form-control' required></div>");
            $("#add-function").append("<div name='eventtime"+eventCount+"'"+" class='form-group'><label> Event"+ eventCount +" Time </label> <input name='event-time-"+eventCount+"' class='form-control' type='time' required></div>");
        }
    });

    $(document).on('click','#save-function-btn', function(e){
        e.preventDefault();
        var error = functionError();
        if(error>0)
            $("#error").css({'display': "block"});
        else{
            $("#error").css({'display': "none"});
            var input_data={"count": eventCount};
            for(let i=0;i<eventCount;i++)
            {
                var eventName =document.getElementsByName("event-"+(i+1))[0].value;
                var eventTime =document.getElementsByName("event-time-"+(i+1))[0].value;
                input_data["eventName_"+(i+1)] = eventName;
                input_data["eventTime_"+(i+1)] = eventTime;
            }
            input_data['functionName'] = $("[name=function-name]").val();
            input_data['functionDate'] = $("[name=function-date]").val();
            input_data['functionTime'] = $("[name=function-time]").val();

            $.ajax({
                url: "/addfunction",
                data: input_data,
                type: "post",
                success: function(response){
                    for(let i=0;i<eventCount;i++){
                        document.getElementsByName("eventname"+(i+1))[0].remove();
                        document.getElementsByName("eventtime"+(i+1))[0].remove();
                    }
                    document.getElementById("add-function").reset();
                    document.getElementById("add-function-container").style.display="none";
                    alert("Event saved Successfully");
                },
                error: function(){
                    alert("There are errors in the forms");
                }
            });
        }
    });

    $(document).on('click','.event-cancel', function(e){
        e.preventDefault();
        var num = this.name;
        var elem1 = document.getElementsByName("eventname"+num)[0];
        var elem2 = document.getElementsByName("eventtime"+num)[0];
        elem1.remove();
        elem2.remove();
        for(var i=parseInt(num)+1;i<=eventCount;i++){
            var divelement1 = document.getElementsByName("eventname"+i)[0];
            var divelement2 = document.getElementsByName("eventtime"+i)[0];
            document.getElementsByName(i)[0].setAttribute('name',i-1);
            divelement1.firstChild.innerHTML = "Event"+(i-1);
            divelement1.lastChild.setAttribute("name", "event-"+(i-1));
            divelement1.setAttribute("name","eventname"+(i-1));
            divelement2.firstChild.innerHTML = "Event"+(i-1)+" Time";
            divelement2.lastChild.setAttribute("name", "event-time-"+(i-1));
            divelement2.setAttribute("name","eventtime"+(i-1));
        } 
        eventCount--;
    });
});
