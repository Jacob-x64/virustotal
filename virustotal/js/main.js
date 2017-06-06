
function presort() {
    var str = document.getElementById("presort_arrow").innerHTML; 
    var res = str.replace(/./, '');

    document.getElementById("presort_arrow").innerHTML = res;
}

function load_data(){
        var u = document.getElementById('loading');
        //fun loader
	u.innerHTML = "<h1>Loading, please wait...</h1><img src='loading.gif' alt='Loading Results...'/>";
	//supa seriouz loader
	//u.innerHTML = "<h1>Loading, please wait...</h1><img height='50' width='50' src='ajax-loader.gif' alt='Loading Results...'/>";
}
function clear_load(){
	var u = document.getElementById('loading');
	u.innerHTML = "";
}

