$(document).ready(function(){
    $(".inputtype").change(function(){
        
        var inputTypeName = $(this).attr('id');   
        var data = inputTypeFn($(this).val(),inputTypeName);        
        $("#"+inputTypeName+"-custom").html(data.result);
    });
});


function inputTypeFn(inputTypeVal,inputTypeName){
    
    var custom;
    
    switch(inputTypeVal){
        
        case '':
            custom = '';
        break;
        
        case 'text':
            custom = '<div>';
            custom += '<div class="input-prepend">';
            custom += '<label class="radio inline">';
            custom += '<input type="radio" value="yes" name="'+inputTypeName+'[date]" />Jquery Date Picker';
            custom += '</label>';
            custom += '</div>';
            custom += '<span class="help-inline"></span>';
            custom += '</div>';
        break;
        
        case 'password':
            custom = 'Password';
        break;
    
        case 'dropdown':
            custom = customFieldsVOP(inputTypeName);          
        break;
        
        case 'radio':
            custom = customFieldsVOP(inputTypeName);
        break;
        
        case 'checkbox':
            custom = customFieldsVOP(inputTypeName);
        break; 
        
        case 'file':
            custom = 'File Res';
        break;
        
        case 'textarea':
            custom = 'Text Area';
        break;
        
        case 'hidden':
            custom = customFieldsVal(inputTypeName);
        break;
        
        case 'NA':
            custom = 'NA';
        break;
        
        default:
        break;

    }
    return{
        result: custom
    }
}

function customFieldsVOP(inputTypeName){
    
    var customFieldsVOP;
    
    customFieldsVOP = '<div>';
    customFieldsVOP += '<div class="input-prepend input-append">';
    customFieldsVOP += '<div class="add-on" >Value <i class="icon-hand-right"></i></div>';
    customFieldsVOP += '<input type="text" name="'+inputTypeName+'[value][]" class="span3" data-rule-required="true" data-msg-required="Please Enter '+inputTypeName+' value field "/>'; 
    customFieldsVOP += '<div class="add-on" >Option <i class="icon-hand-right"></i></div>';
    customFieldsVOP += '<input type="text" name="'+inputTypeName+'[option][]" class="span3" data-rule-required="true" data-msg-required="Please Enter '+inputTypeName+' option field " />';
    customFieldsVOP += '<div class="add-on" ></div>';
    customFieldsVOP += '</div>';
    customFieldsVOP += '<span class="help-inline"></span>';
    customFieldsVOP += '</div>';
    
    return customFieldsVOP;
}

function customFieldsVal(inputTypeName){
    
    var customFieldsV;
    
    customFieldsV = '<div>';
    customFieldsV += '<div class="input-prepend input-append">';
    customFieldsV += '<div class="add-on" >Value <i class="icon-hand-right"></i></div>';
    customFieldsV += '<input type="text" name="'+inputTypeName+'[value][]" class="span3" data-rule-required="true" data-msg-required="Please enter '+inputTypeName+' hidden value field "/>'; 
    customFieldsV += '<div class="add-on" ></div>';
    customFieldsV += '</div>';
    customFieldsV += '<span class="help-inline"></span>';
    customFieldsV += '</div>';
    
    return customFieldsV;
}