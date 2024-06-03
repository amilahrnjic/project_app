var Constants = {
  
 
    get_api_base_url: function () {
      if(location.hostname == 'localhost'){
        return "http://localhost/project_final/admin/live-backend/";
      } else {
        return "https://sea-turtle-app-l52v8.ondigitalocean.app/admin/live-backend/";
      }
    }
  


  
  
  
  //API_BASE_URL: "http://localhost/project_final/admin/live-backend/",
};