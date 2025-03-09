function modify(id) {
    
    document.getElementById("invisible_a_" + id).style.display = 'block';
    document.getElementById("visible_a_" + id).style.display = 'none';

    document.getElementById("invisible_b_" + id).style.display = 'block';
    document.getElementById("visible_b_" + id).style.display = 'none';

    document.getElementById("invisible_c_" + id).style.display = 'block';
    document.getElementById("visible_c_" + id).style.display = 'none';

    document.getElementById("invisible_d_" + id).style.display = 'block';
    document.getElementById("visible_d_" + id).style.display = 'none';

    document.getElementById("invisible_e_" + id).style.display = 'block';
    document.getElementById("visible_e_" + id).style.display = 'none';

    document.getElementById("invisible_f_" + id).style.display = 'block';
    document.getElementById("visible_f_" + id).style.display = 'none';
    
}

function validate_week_form()
      {
       var inputElems = document.getElementsByTagName("input");
        countCheckbox = 0;

        numberMeal = document.getElementById('meal_number').value;

        for (var i=0; i<inputElems.length; i++) {       
           if (inputElems[i].type == "checkbox" && inputElems[i].checked == true){
                countCheckbox++;
           }

        }

        let hasErrors = false; 

        if (countCheckbox!=numberMeal) {
            document.getElementById("missing_recipes").style.display = 'block';
            hasErrors = true;
        }

        if (hasErrors) { 
            event.preventDefault(); 
        } 

     }

function choose_recipe(){
        countCheckbox = 0;

        numberMeal = document.getElementById('meal_number').value;

        inputElems = document.getElementsByTagName("input");

        for (var i=0; i<inputElems.length; i++) {       
           if (inputElems[i].type == "checkbox" && inputElems[i].checked == true){
                countCheckbox++;
           }
        }

        rows = document.getElementsByName("choosen_recipe[]");

        while (countCheckbox<numberMeal) {
            random = Math.floor(Math.random() * (rows.length));

            if (rows[random].checked == true || rows[random].className == "red"){
                continue;
            } 

            rows[random].checked = true;

            countCheckbox++;
        }

}
     