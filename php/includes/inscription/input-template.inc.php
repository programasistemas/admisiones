<?php
/**
 * FUNCIÓN PARA GENERAR ESTRUCTURA HTML DE INPUTS CON EL FORMATO DEL PROCESO DE INSCRIPCIÓN.
 * Necesita que traiga el tipo de input, por defecto será «simpleBox».
 * @param array $values es un array asociativo, en él trae la información que se utilizará para imprimir el input
 * Algunas de las propiedades del array son extrictamente obligatorias, otras por el contrario, se generan de forma autonóma 
 * con la función «getDefaultValues()» pasandole el tipo de input que trajo $values, aunque, igualmente, estos valores puede editarlos.
 * «types» admitidos: simpleBox | inputWithList | tel | radio | select | file | checkbox | showInput
 */
function createTemplateFields($values)
{
    if (!isset($values['type'])) $type = '';
    else $type = $values['type'];
    //Tomamos los valores por defecto, y los actualizamos con los que trae el cliente.
    $values = array_replace(getDefaultValues($type), $values);

    //Lo volvemos en formato object class para manipularlo más fácil.
    $input = json_decode(json_encode($values), FALSE);
    if (isset($input->isDisplayNone) && $input->isDisplayNone == true) $input->attrParent .= ' style="display:none;"';

    //Respuesta template:
    $res = '';

    //Dependiendo el tipo de input genere:
    switch ($input->type) {
        case 'no-display':
            $res = createTemplateInput($input);
            break;


        case 'simpleBox':
            $res = "<div class='$input->classGrid fieldParentLabel $input->extraClass' $input->attrParent>" . createTemplateInput($input) . "</div>";
            break;


        case 'tel':
            $res = "<div class='$input->classGrid fieldParentLabel'>" . createTemplateInput($input) . "</div>";
            break;

        case 'select':
            if( isset($input->isDisabled) && $input->isDisabled === true ) $input->attr .= 'disabled';
            $res = "<div class='$input->classGrid fieldParentLabel' $input->attrParent>";
            if ($input->createHidden == 'SI') $res .=
                        "<input type='hidden' name='$input->id' value='$input->value'>";

            $res .=     "<select id='$input->id'" . ($input->createHidden == 'SI' ? '' : "name='$input->id'") . "class='form-select' ". $input->attr .'>';
            if( isset($input->options) && !empty($input->options) ){
                foreach ($input->options as $option) $res .=
                                '<option data-value="' . $option[0] . '" ' . ($option[0] == $input->value ? 'selected' : '') . '>' . $option[1] . '</option>';
            }
            $res .=    '</select>';
            
            if (isset($input->label)) $res .=
                        "<label class='$input->classLabel'>$input->label</label>";


            if (isset($input->msjError)) $res .=
                        "<span class='msj'>$input->msjError</span>";
            $res .= '</div>';
            break;

        case 'templateFile':
            $values = $input->upload
            ? ['color'=>'btn-outline-danger',   'icon'=>'fas fa-cloud-upload-alt',  'text'=>'Cargar '.$input->text,    'extraClass'=>'upload']
            : ['color'=>'btn-primary',          'icon'=>'fas fa-file-pdf',          'text'=>'Ver '.$input->text,       'extraClass'=>'showFile'];
            if( isset($input->color) ) $values['color'] = $input->color;

            $res = '<div class="input_file '.$input->classGrid.' position-relative" '.$input->attrParent.'>'.
                        '<div class="form-control btn '.$values['color'].' '.$values['extraClass'].'" url='.$input->url.'>'.
                            '<i class="'.$values['icon'].'"></i>'.
                            '<p default-text="'.$values['text'].'">'.$values['text'].'</p>'.
                        '</div>';
            if( $input->upload ){
                if( isset($input->observation) ) $res .= 
                        '<i class="fas fa-question-circle position-absolute show_info_files" data-toggle="tooltip" data-bs-placement="top" title="Ver observación" text-obs="' . $input->observation . '"></i>';
                $res .= '<input type="file" class="d-none" '.
                            ( isset($input->noName) ? '' : 'name="'.$input->id.'"').
                            ' id="'.$input->id.'" accept="'.$input->formatAccept.'" '.$input->attr.
                        '>'.
                        '<span class="msj"></span>';
            }
            if( isset($input->moreHtml) ) $res .= $input->moreHtml;
            $res .= '</div>';
        break;

        case 'checkbox':
            $input->class .= ' form-check-input';
            $input->attr .= ' role="switch" ';
            if ($input->isChecked == true) $input->checked = '';

            $res = '<div class="d-flex ' . $input->classGrid . '">
                        <div class="form-check form-switch ' . $input->classContent . '" style="width: fit-content">'; //m-auto
            $res .=         createTemplateInput($input);
            if (isset($input->msjExtra)) $res .= $input->msjExtra;
            $res .= '   </div>
                    </div>';
            break;

        case 'button':
            $input->attr .= $input->isDisabled ? ' disabled' : '';
            $res = "<div class='$input->classGrid fieldParentLabel $input->extraClass' $input->attrParent>" .
                        "<button class='btn w-100 $input->classContent' id='$input->id' $input->attr> $input->content </button>".
                    "</div>";
            break;


        case 'showInput':
            $res = "<div class='$input->classGrid fieldParentLabel'" . $input->attrParent . '>';

            if (isset($input->textarea)) $res .= "<textarea class='form-control fieldInput' disabled> $input->value </textarea>";
            else $res .= "<input type='$input->typeValue' class='form-control fieldInput' value='$input->value' disabled>";

            if (isset($input->label)) $res .= "<label class='input__placeholder'>$input->label</label>";
            $res .= '</div>';
            break;

        default: throw new Exception('Tipo de input esperado, desconocido');
    }
    return $res;
}

function createSectionAccordion($accordion){
    $title = $accordion['title'];
    $id = $accordion['id'];
    $content = isset($accordion['content']) ? $accordion['content'] : '';
    $collapse = !isset($accordion['show']) || $accordion['show'] !== true;

    return '<div class="accordion-item">
                <h2 class="accordion-header" id="heading_'.$id.'">
                    <button class="accordion-button '.($collapse ? 'accordion-collapse collapsed' : '').'" type="button" data-bs-toggle="collapse" data-bs-target="#'.$id.'" aria-expanded="false" aria-controls="'.$id.'">
                        '.$title.'
                    </button>
                </h2>

                <div id="'.$id.'" class="accordion-collapse collapse '.($collapse ? '' : 'show').'" aria-labelledby="heading_'.$id.'" data-bs-parent="#accordionInscription">
                    <div class="accordion-body"> <div class="row">'. $content .'</div> </div>
                </div>
            </div>';
}

/**
 * Genera una plantilla de input, con la información dada por parametro
 * @param object @objeto con atributos del template a imprimir.
 * @return string template html del input a imprimir.
 */
function createTemplateInput($info)
{
    if (isset($info->isDisabled) && $info->isDisabled) $info->disabled = '';

    if (!isset($info->name)) $info->name = isset($info->id) ? $info->id : '';
    $tag = isset($info->textarea) ? 'textarea' : 'input';
    $template = '<' . $tag . ' name="' . $info->name . '" ';
    if (isset($info->id))                       $template .= 'id="' . $info->id . '" ';
    if (isset($info->list))                     $template .= 'list="' . $info->list . '" ';
    if (isset($info->attr))                     $template .= $info->attr . ' ';
    if (isset($info->rgx))                      $template .= 'rgx="' . $info->rgx . '" ';
    if (isset($info->typeValue))                $template .= 'type="' . $info->typeValue . '" ';
    if (isset($info->class))                    $template .= 'class="' . $info->class . ' py-2" ';
    if (isset($info->formatAccept))             $template .= 'accept="' . $info->formatAccept . '" ';
    if (isset($info->disabled))                 $template .= 'disabled ';
    if (isset($info->readonly))                 $template .= 'readonly ';
    if (isset($info->checked))                  $template .= 'checked ';
    if (!empty($info->autocomplete))           $template .= 'autocomplete="' . $info->autocomplete . '" ';
    if (!empty($info->placeholder))            $template .= 'placeholder="' . $info->placeholder . '" ';
    if (isset($info->value) && $tag == 'input') $template .= 'value="' . $info->value . '" ';
    $template .= '>';

    if ($tag == 'textarea') {
        if (isset($info->value)) $template .= $info->value;
        $template .= '</textarea>';
    }

    if (isset($info->helper)) $template .= '<i class="fas fa-question-circle tooltip_helper" data-toggle="tooltip" data-bs-placement="top" title="' . $info->helper . '"></i>';

    if (isset($info->label)) {
        $template .= '<label class="' . $info->classLabel . '" ';
        if (isset($info->id))          $template .= 'for="' . $info->id . '" ';
        if (isset($info->styleLabel))  $template .= 'style="' . $info->styleLabel . '"';
        $template .= '>' . $info->label . '</label>';
    }
    if (isset($info->msjError))        $template .= '<span class="msj">' . $info->msjError . '</span>';

    return $template;
}


/**
 * Obtener array asociativo con propiedades por defecto dependiendo el tipo de input
 * que se desea imprimir.
 * @param string $type tipo de input que desea imprimir (relacionado al switch case de la función «printInput»)
 * @return array retorna array asociativo con propiedades por defecto.
 */
function getDefaultValues($type)
{
    $properties = [
        'type' => 'simpleBox',
        'typeValue' => 'text',
        'classGrid' => 'col-12 col-sm-6 col-xl-3 mb-4',
        'class' => 'form-control fieldInput',
        'classLabel' => 'input__placeholder',
        'placeholder' => ' ',
        'extraClass' => '',
        'autocomplete' => 'off',
        'attr' => '',
        'attrParent' => '',
        'value' => ''
    ];

    //añadimos otro tipo de propiedades, especiales por el tipo de input:
    switch ($type) {
        case 'button':
            $properties['content'] = '';
            $properties['classContent'] = 'btn-primary';
        case '':
        case 'simpleBox':
            $properties['classGrid'] = 'col-12 col-sm-6 col-lg-3 mb-4';
            break;

        case 'select':
            $properties = array_replace($properties, [
                'classGrid' => 'col-12 col-lg-6 mb-4',
                'classLabel' => 'input__select_placeholder',
                'value' => '',
                'createHidden' => 'SI',
                'attr'=>''
            ]);
            break;

        case 'templateFile':
            $properties = array_replace($properties, [
                'classGrid' => 'col-12 col-lg-6 col-xxl-4 mt-4',
                'formatAccept' => 'application/pdf',
                'upload'=>true,
                'url'=>'',
                'attrParent'=>'', 'attr'=>''
            ]);

        case 'tel':
            $properties['typeValue'] = 'tel';
            $properties['classLabel'] = 'input__check_placeholder';
            $properties['placeholder'] = '';
            break;
            

        case 'checkbox':
            $properties = array_replace($properties, [
                'isChecked' => false,
                'typeValue' => $type,
                'class' => 'form-check-input',
                'classLabel' => 'form-check-label',
                'autocomplete' => '',
                'placeholder' => '',
                'classContent' => ''
            ]);
            break;

        case 'no-display':
            $properties['typeValue'] = 'hidden';
            break;
        case 'showInput':
            $properties['classGrid'] = 'col-12 col-md-6 mb-4';
            break;

        case 'button':
            $properties['isDisabled'] = false;
            break;
    }
    return $properties;
}
