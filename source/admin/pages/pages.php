<!--Pages for admin panel-->
<div class="container">

  <!--Toolbar-->
  <h1>Manage Pages</h1>
  <div class="panel panel-default">
    <div class="panel-body">
      <button class="btn btn-primary" id="newpage-button">Create a new page</button>
    </div>
  </div>

  <div class="panel panel-default">
    <div class="panel-body">
      <h4>Page List</h4>
      <table class="table">
        <thead>
          <tr>
            <th>Title</th>
            <th>Keywords</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="page-list-container"></tbody>
      </table>
    </div>
  </div>

  <!--Create and edit panel-->
  <div class="panel panel-default" style="display:none;" id="edit-panel">
    <div class="panel-body">
      <form role="form">
        <div class="form-group">
          <input id="page-title-box" class="form-control input-lg" value="untitled page" type="text" placeholder="">
        </div>
        <div class="form-group">
          <input id="page-description-box" class="form-control input-md" value="type page description here..." type="text" placeholder="">
        </div>
        <div class="form-group">
          <input id="page-keywords-box" class="form-control input-md" value="type page keywords here..." type="text" placeholder="">
        </div>
        <div class="form-group">
          <textarea id="page-content-box" style="height:300px;" class="form-control input-md" type="text" placeholder=""></textarea>
        </div>
        <button class="btn btn-primary" type="button" id="edit-panel-create-button">Create</button>
        <button class="btn btn-primary" type="button" id="edit-panel-save-button">Save</button>
        <button class="btn btn-danger" type="button" id="edit-panel-cancel-button">Cancel</button>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
  $("#newpage-button").click(function(){
    initEditPanel("untitled page","type page description here...","type page keywords here...","",1);
    $("#edit-panel").slideDown();
  });

  $("#edit-panel-cancel-button").click(function(){
    $("#edit-panel").slideUp();
  });


  $("#edit-panel-create-button").click(function(){
    $.ajax({
      url:"../api/",
      type:"POST",
      data:{
        action:"create_page",
        title:$("#page-title-box").val(),
        description:$("#page-description-box").val(),
        keywords:$("#page-keywords-box").val(),
        content:$("#page-content-box").val()
      },
      dataType:"json",
      success:function(data){
        if(data["status"] == "success"){
          alert("Page created");
          location.reload();
        } else {
          alert("Failed to create page, are you loggedin?");
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
        action:"update_page",
        old_title:pageData[currentEditIndex]["title"],
        title:$("#page-title-box").val(),
        description:$("#page-description-box").val(),
        keywords:$("#page-keywords-box").val(),
        content:$("#page-content-box").val()
      },
      dataType:"json",
      success:function(data){
        if(data["status"] == "success"){
          alert("Page updated");
          location.reload();
        } else {
          alert("Failed to update page, are you loggedin?");
        }
      },
      error:function(e){
        console.log(e);
      }
    });
  });

  var pageData;
  $.ajax({
    url:"../api/",
    type:"POST",
    data:{
      action:"get_all_pages"
    },
    dataType:"json",
    success:function(data){
      tableContent = "";
      pageData = data["data"];
      //++i is faster than i++ for older compilers
      for(i = 0; i < pageData.length; ++i){
        tableContent += "<tr><td>" + pageData[i]["title"] + "</td><td>" + pageData[i]["keyword"] + "</td><td>" +
        "<button class='btn btn-primary' onclick='showEditPanel(" + i + ")'>Edit</button> " +
        "<button class='btn btn-danger' onclick='deletePage(" + i + ")'>Delete</button>" +
        "</td></tr>";
      }
      $("#page-list-container").html(tableContent);
    },
    error:function(e){
      console.log(e);
    }
  });

  //Run a ajax request to delete a page
  function deletePage(index){
    $.ajax({
      url:"../api/",
      type:"POST",
      data:{
        action:"delete_page",
        title:pageData[index]["title"]
      },
      dataType:"json",
      success:function(data){
        if(data["status"] == "success"){
          alert("Page deleted");
          location.reload();
        } else {
          alert("Failed to delete page, are you loggedin?");
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
    initEditPanel(pageData[index]["title"],pageData[index]["description"],pageData[index]["keyword"],pageData[index]["content"],2);
    $("#edit-panel").slideDown();
  }

  function initEditPanel(title,description,keywords,content,type){
    $("#page-title-box").val(title);
    $("#page-description-box").val(description);
    $("#page-keywords-box").val(keywords);
    $("#page-content-box").text(content);
    if(type == 1){
      $("#edit-panel-save-button").hide();
      $("#edit-panel-create-button").show();
    } else {
      $("#edit-panel-save-button").show();
      $("#edit-panel-create-button").hide();
    }
  }
</script>
