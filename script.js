function modify_table_row(id) {
    
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

        // Determine the current season
        numberMeal = document.getElementById('meal_number').value;
        mealDate = new Date(document.getElementById('meal_date').value);

        if (mealDate.getMonth() == 11 || mealDate.getMonth() == 0 || mealDate.getMonth() == 1) {
            currentSeason = 2;
        } else if (mealDate.getMonth() == 2 || mealDate.getMonth() == 3 || mealDate.getMonth() == 4) {
            currentSeason = 3;
        } else if (mealDate.getMonth() == 5 || mealDate.getMonth() == 6 || mealDate.getMonth() == 7) {
            currentSeason = 4;
        } else if (mealDate.getMonth() == 8 || mealDate.getMonth() == 9 || mealDate.getMonth() == 10) {
            currentSeason = 5;
        }

    
        // Count the checkboxes that are already checked and attributes already used
        inputElems = document.getElementsByTagName("input");

        for (var j=0; j<inputElems.length; j++) {       
           if (inputElems[j].type == "checkbox" && inputElems[j].checked == true){
                countCheckbox++;

                //console.log("Recette " + inputElems[j].value);

                // Initialize the attributes' counts
                attributeValueInit = "attribute_" + inputElems[j].value;
                getAttributeInit = document.getElementsByName(attributeValueInit);

                for (var i = 0; i < getAttributeInit.length; i++) {

                    for (var k = 0; k < getAllAttributes.length; k++) {

                        if (getAttributeInit[i].value == getAllAttributes[k][0]){
                            getAllAttributes[k][2] = getAllAttributes[k][2] + 1;
                        }

                    }
                }

           }
        }

        rows = document.getElementsByName("choosen_recipe[]");

        while (countCheckbox<numberMeal) {
            random = Math.floor(Math.random() * (rows.length));
            //console.log("The selected recipe is " + rows[random].value);

            // If the checkbox is already selected, we don't use it
            if (rows[random].checked == true || rows[random].className == "red"){
                console.log("Already checked");
                continue;
            } else {
                //console.log("The recipe is not already checked");

                seasonValue = "season_" + rows[random].value;
                getSeason = document.getElementsByName(seasonValue);

                isSeasonAppropriate = false;

                var getSeason = document.getElementsByName(seasonValue);

                for (var i = 0; i < getSeason.length; i++) {

                    if (getSeason[i].value == currentSeason || getSeason[i].value == 1){
                        isSeasonAppropriate = true;
                    }

                }

                // If the season is not appropriate, we don't use it
                if (isSeasonAppropriate == false){
                    //console.log("Not the right season");
                    continue;   
                } else {

                    //console.log("The season is appropriate");

                    attributeValue = "attribute_" + rows[random].value;
                    getAttribute = document.getElementsByName(attributeValue);

                    isAttributeOk = true; 

                    for (var i = 0; i < getAttribute.length; i++) {

                        for (var k = 0; k < getAllAttributes.length; k++) {

                            if (getAttribute[i].value == getAllAttributes[k][0] && getAllAttributes[k][1] <= getAllAttributes[k][2]){
                                isAttributeOk = false;

                            }
                        }
                    }

                    if (isAttributeOk == false){
                        //console.log("The attribute is already full");
                    } else {

                        //console.log("The attributes are not overused");
                        
                        for (var i = 0; i < getAttribute.length; i++) {

                            for (var k = 0; k < getAllAttributes.length; k++) {
    
                                if (getAttribute[i].value == getAllAttributes[k][0]){
                                    getAllAttributes[k][2] = getAllAttributes[k][2] + 1;
                                }
    
                            }
                        }

                        //console.log("OK, selected");
                        rows[random].checked = true;

                        countCheckbox++;
                    }

                }

            }

        }

}
     