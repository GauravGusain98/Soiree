/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

const { each, post } = require('jquery');

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
    var oldDate="";

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
        $("#show-function-container").css({'display':"none"});
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
        $("#show-function-container").css({'display':"none"});
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
        $("#show-function-container").css({'display':"none"});
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
        $("#show-function-container").css({'display':"none"});
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
                error: function(error){
                    alert(JSON.parse(error.responseText).message);
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

    $(document).on('click',".show-function-btn",function(e){
        e.preventDefault();
        $("#requests-table").css({'display':'none'});
        $("#guests-table").css({'display':'none'});
        $("#cancelled-requests-table").css({'display':'none'});
        $("#add-function-container").css({'display':"none"});
        $("#show-function-container").css({'display':"block"});

        $.ajax({
            url: "/showfunction",
            type: "post",
            success: function(response){
                document.getElementById("show-function-container").innerHTML="";
                console.log(response);
                if(response.length > 0){
                    var i=0;
                    response.forEach(function(element){
                        i++;
                        var div = document.getElementById("show-function-container");
                        var collapsehead =document.createElement("div");
                        collapsehead.setAttribute("id","functionAccordian"+i);
                        collapsehead.classList.add("card");
                        var btn1 =document.createElement("button");
                        btn1.classList.add("btn", "btn-link", "btn-dark", "text-light");
                        btn1.setAttribute("data-toggle", "collapse");
                        btn1.style.cssText="text-align:left";
                        btn1.setAttribute("data-target", "#collapse"+i);
                        btn1.innerHTML= element['Name'];
                        collapsehead.appendChild(btn1);
                        var editBtn =document.createElement("a");
                        editBtn.setAttribute('href',"");
                        editBtn.setAttribute('id',"edit-function"+i);
                        editBtn.setAttribute('class',"text-danger edit-function");
                        editBtn.style.cssText="margin-top: 5px; position: absolute; right:1px; font-size: 2em;";
                        editBtn.innerHTML = '<i class="fas fa-pen-square"></i>'
                        collapsehead.appendChild(editBtn);
                        div.appendChild(collapsehead);
                        var cardbody =document.createElement("div");
                        cardbody.classList.add("collapse", "hide");
                        cardbody.setAttribute("id", "collapse"+i);
                        collapsehead.appendChild(cardbody);
                        var cardText = document.createElement("div");
                        cardText.setAttribute('id', "function-data-"+i);
                        cardText.innerHTML = "<p name='name"+ i +"' > Function: "+"<a id='a_name"+ i +"'>"+element['Name']+"</a>"+"</p> <p name='date"+ i +"'> Date: "+"<a id='a_date"+ i +"'>"+element['Date']+"</a>"+"</p> <p name='time"+ i +"'> Time: "+"<a id='a_time"+ i +"'>"+element['Time']+"</a>"+"</p>";
                        var len = Object.keys(element).length;
                        for (var j=1;j<=(len-3)/2;j++){
                            if(element['event1']!=null){
                                var para1 = document.createElement("p");
                                para1.setAttribute('name','eventname'+j);
                                para1.innerHTML = "Event"+j+": "+element['event'+j];
                                var para2 = document.createElement("p");
                                para2.setAttribute('name','eventname'+j);
                                para2.innerHTML ="Event Time: "+element['eventTime'+j];
                                cardText.appendChild(para1);
                                cardText.appendChild(para2);
                            }
                        }
                        cardText.classList.add("card-body", "ml-2");
                        cardbody.appendChild(cardText);          
                    });   
                }
            }
        });
    });


    $(document).on('click','.edit-function', function(e){
        e.preventDefault();
        var id = this.id.substr(-1);
        if(document.getElementById("save-function"+id) != null){
            document.getElementById("save-function"+id).remove();
            document.getElementById("delete-function"+id).remove();
            document.getElementById("cancel-edit"+id).remove();
        }
        var collapseDiv = document.getElementById("collapse"+id);
        var saveBtn = document.createElement('button');
        saveBtn.innerHTML = "Save";
        saveBtn.setAttribute("id", "save-function"+id);
        saveBtn.classList.add("btn","btn-success","editfunction-save-btn");
        var cancelBtn = document.createElement('button');
        cancelBtn.innerHTML = "Cancel";
        cancelBtn.classList.add("btn","btn-danger","editfunction-cancel-btn", "show-function-btn");
        var deleteBtn = document.createElement('button');
        deleteBtn.innerHTML = "Delete";
        deleteBtn.setAttribute("id", "delete-function"+id);
        deleteBtn.classList.add("btn","btn-light","editfunction-delete-btn");
        collapseDiv.appendChild(saveBtn);
        collapseDiv.appendChild(cancelBtn);
        collapseDiv.appendChild(deleteBtn);
        var name = document.getElementsByName("name"+id)[0];
        var date = document.getElementsByName("date"+id)[0];
        oldDate = date.lastChild.innerHTML;
        var time = document.getElementsByName("time"+id)[0];
        var input_name = document.createElement("input");
        var input_date = document.createElement("input");
        var input_time = document.createElement("input");
        input_name.setAttribute("class", "form-control");
        input_name.setAttribute("name", "i_name"+id);
        input_name.setAttribute("value", name.lastChild.innerHTML);
        input_date.setAttribute("class", "form-control");
        input_date.setAttribute("name", "i_date"+id);
        input_date.setAttribute("type", "date");
        input_date.setAttribute("value", date.lastChild.innerHTML);
        input_time.setAttribute("class", "form-control");
        input_time.setAttribute("name", "i_time"+id);
        input_time.setAttribute("type", "time");
        input_time.setAttribute("value", time.lastChild.innerHTML);
        name.lastChild.remove();
        name.appendChild(input_name);
        date.lastChild.remove();
        date.appendChild(input_date);
        time.lastChild.remove();
        time.appendChild(input_time);
    });
    
    $(document).on('click','.editfunction-delete-btn', function(e){
        e.preventDefault();
        var id = this.id.substr(-1);
        var date = document.getElementsByName("date"+id)[0].innerHTML.substr(7);
        $.ajax({
            url: "/deletefunction",
            type: "post",
            data : {'date': date},
            success: function(response){
                document.getElementById("functionAccordian"+id).remove();
            }
        });
        console.log(id, date);
    });

    $(document).on("click", ".editfunction-save-btn", function(e){
        e.preventDefault();
        var id = this.id.substr(-1);
        var name = document.getElementsByName("i_name"+id)[0].value;
        var date = document.getElementsByName("i_date"+id)[0].value;
        var time = document.getElementsByName("i_time"+id)[0].value;
        $.ajax({
            url: ".savefunction",
            data: {"name": name, "date": date, "oldDate": oldDate, "time": time },
            success: function(response){

            },
            error: function(response){
                alert(JSON.parse(error.responseText).message);
            }
        })
        console.log(name , date, time);
    });
});
