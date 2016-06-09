<!--Navigation for admin panel-->
<div class="container">

  <!--Toolbar-->
  <h1>Manage Navigation</h1>
  <div class="panel panel-default">
    <div class="panel-body">
      <button class="btn btn-primary" id="newnav-button">Create a new navigation element</button>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-body">
      <h4>Navigation Element List</h4>
      <table class="table">
        <thead>
          <tr>
            <th>Display Order</th>
            <th>Display Text</th>
            <th>Link</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="nav-list-container"></tbody>
      </table>
    </div>
  </div>

  <!--Create and edit panel-->
  <div class="panel panel-default" style="display:none;" id="edit-panel">
    <div class="panel-body">
      <form role="form">
        <div class="form-group">
          <input id="nav-text-box" class="form-control input-md" type="text" placeholder="Display Text">
        </div>
        <div class="form-group">
          <input id="nav-link-box" class="form-control input-md" type="text" placeholder="Link (Relative or Absolute)">
        </div>
        <div class="form-group">
          <input id="nav-order-box" class="form-control input-md" type="number" placeholder="Display Order (Integer)">
        </div>
        <button class="btn btn-primary" type="button" id="edit-panel-create-button">Create</button>
        <button class="btn btn-primary" type="button" id="edit-panel-save-button">Save</button>
        <button class="btn btn-danger" type="button" id="edit-panel-cancel-button">Cancel</button>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $("#newnav-button").click(function(){
    initEditPanel("","","",1);
    $("#edit-panel").slideDown();
  });

  $("#edit-panel-cancel-button").click(function(){
    initEditPanel("","","",1);
    $("#edit-panel").slideUp();
  });

  $("#edit-panel-create-button").click(function(){
    $.ajax({
      url:"../api/",
      type:"POST",
      data:{
        action:"create_nav",
        text:$("#nav-text-box").val(),
        order:$("#nav-order-box").val(),
        link:$("#nav-link-box").val()
      },
      dataType:"json",
      success:function(data){
        if(data["status"] == "success"){
          alert("Navigation created");
          location.reload();
        } else {
          alert("Failed to create navigation, are you loggedin?");
        }
      },
      error:function(e){
        console.log(e);
      }
    });
  });

  $("#edit-panel-save-button").click(function(){
    $.ajax({
      url:"../api/",
      type:"POST",
      data:{
        action:"update_nav",
        old_text:navData[currentEditIndex]["text"],
        text:$("#nav-text-box").val(),
        link:$("#nav-link-box").val(),
        order:$("#nav-order-box").val()
      },
      dataType:"json",
      success:function(data){
        if(data["status"] == "success"){
          alert("Nav updated");
          location.reload();
        } else {
          alert("Failed to update nav, are you loggedin?");
        }
      },
      error:function(e){
        console.log(e);
      }
    });
  });

  var navData;
  $.ajax({
    url:"../api/",
    type:"POST",
    data:{
      action:"get_all_navs"
    },
    dataType:"json",
    success:function(data){
      tableContent = "";
      navData = data["data"];
      //++i is faster than i++ for older compilers
      for(i = 0; i < navData.length; ++i){
        tableContent += "<tr><td>" + navData[i]["order"] + "</td><td>" + navData[i]["text"] + "</td><td>" + navData[i]["link"] + "</td><td>" +
        "<button class='btn btn-primary' onclick='showEditPanel(" + i + ")'>Edit</button> " +
        "<button class='btn btn-danger' onclick='deleteNav(" + i + ")'>Delete</button>" +
        "</td></tr>";
      }
      $("#nav-list-container").html(tableContent);
    },
    error:function(e){
      console.log(e);
    }
  });

  //Run a ajax request to delete a page
  function deleteNav(index){
    $.ajax({
      url:"../api/",
      type:"POST",
      data:{
        action:"delete_nav",
        text:navData[index]["text"]
      },
      dataType:"json",
      success:function(data){
        if(data["status"] == "success"){
          alert("Nav deleted");
          location.reload();
        } else {
          alert("Failed to delete nav, are you loggedin?");
          console.log(data);
        }
      },
      error:function(e){
        console.log(e);
      }
    });
  }

  var currentEditIndex;
  function showEditPanel(index){
    currentEditIndex = index;
    initEditPanel(navData[index]["text"],navData[index]["link"],navData[index]["order"],2);
    $("#edit-panel").slideDown();
  }

  function initEditPanel(text,link,order,type){
    $("#nav-text-box").val(text);
    $("#nav-link-box").val(link);
    $("#nav-order-box").val(order);
    if(type == 1){
      $("#edit-panel-save-button").hide();
      $("#edit-panel-create-button").show();
    } else {
      $("#edit-panel-save-button").show();
      $("#edit-panel-create-button").hide();
    }
  }
</script>
