<?php
//Construction of forms

//Enqueue scripts
function enqueue_form_styles_scripts(){
  /* Enqueue our stylesheet. */
   wp_enqueue_style( 'searchbox', plugins_url().'/e-travel-api-vxl/css/resbox.css' );
   wp_enqueue_script( 'etravel', plugins_url(). '/e-travel-api-vxl/js/etravel.js', array('jquery-ui') );    

}
add_action( 'wp_enqueue_scripts', 'enqueue_form_styles_scripts' );

function search_box_one(){
	return ' 
    <div class="etWContainer">
        <div class="etWtabs">
            <a class="hotel prim active" href="javascript:void(0);">Hotel</a>
            <!-- <a class="package" href="javascript:void(0);">Hotel + Vuelo</a>
            <a class="flight" href="javascript:void(0);">Vuelo</a>
            <a class="car" href="javascript:void(0);">Autos</a>
            <a class="tour" href="javascript:void(0);">Tours</a>
            <a class="transfer" href="javascript:void(0);">Traslados</a> -->
        </div>
        <div class="etWforms">
            <form accept-charset="UTF-8" id="formahotel" class="form" name="formahotel" method="post" action="hoteles.php">
                <div class="etWHide">
                    <input type="hidden" value="TEST" name="Af" />
                    <input type="hidden" name="ln" value="esp" />
                    <input type="hidden" name="cu" value="pe" />
                    <input type="hidden" value="" name="ds" id="Etdt" />
                    <input type="hidden" value="" name="ac1" id="EtNumAges1" />
                    <input type="hidden" value="" name="ac2" id="EtNumAges2" />
                    <input type="hidden" value="" name="ac3" id="EtNumAges3" />
                    <input type="hidden" name="di" value="" id="destinoID" />
                </div>
                <div class="etWrow">
                    <label>&iquest;Qu&eacute; destino u hotel&#63;:</label>
                    <input type="text" value="Especifique una ciudad" name="dn" id="EtDestinyHtl" />
                </div>
                <div class="EtBxLine"></div>
                <div class="etWrow2">
                    <label>Desde:</label>
                    <input type="text" value="" readonly="readonly" name="sd" class="cal EtDateFromGN " />

                </div>
                <div class="etWrow2">
                    <label>Hasta:</label>
                    <input type="text" value="" readonly="readonly" name="ed" class="cal EtDateToGN" />
                </div>
                <div class="EtBxLine"></div>
                <div class="etWrow">
                    <div class="etWheader">
                        <span class="rom">Cuartos:</span>
                        <span class="ads">Adultos</span>
                        <span class="chi">Ni&ntilde;os</span>
                    </div>
                    <div class="etWSelect rm etWSmall">
                        <select name="rm">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                        <span></span>
                    </div>
                    <div id="Room1" class="etWRoom">
                        <span>Cuarto 1:</span>
                        <div class="etWSelect etWSmall adl etWPersons">
                            <select name="ad1">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="etWSelect etWSmall etWPersons">
                            <select name="ch1">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div id="Room2" class="etWRoom">
                        <span>Cuarto 2:</span>
                        <div class="etWSelect etWSmall etWPersons">
                            <select name="ad2">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="etWSelect etWSmall etWPersons">
                            <select name="ch2">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div id="Room3" class="etWRoom">
                        <span>Cuarto 3:</span>
                        <div class="etWSelect etWSmall etWPersons">
                            <select name="ad3">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="etWSelect etWSmall etWPersons">
                            <select name="ch3">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div id="AgeC" class="etWrow">
                    <span class="etHe">Especifique la edad de los ni&ntilde;os (0-12):</span>
                    <div class="etWAge" id="Age1">
                        <label>Edad de los ni&ntilde;os (Habitaci&oacute;n 1):</label>
                        <div class="etWSelect etWSmall age-select ones">
                            <select>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="etWSelect etWSmall age-select two">
                            <select>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="etWSelect etWSmall age-select three">
                            <select>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="etWAge" id="Age2">
                        <label>Edad de los ni&ntilde;os (Habitaci&oacute;n 2):</label>
                        <div class="etWSelect etWSmall age-select ones">
                            <select>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="etWSelect etWSmall age-select two">
                            <select>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="etWSelect etWSmall age-select three">
                            <select>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <span></span>
                        </div>
                    </div>
                    <div class="etWAge" id="Age3">
                        <label>Edad de los ni&ntilde;os (Habitaci&oacute;n 3):</label>
                        <div class="etWSelect etWSmall age-select ones">
                            <select>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="etWSelect etWSmall age-select two">
                            <select>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <span></span>
                        </div>
                        <div class="etWSelect etWSmall age-select three">
                            <select>
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="button_submit">
                    <input type="submit" value="Buscar" />
                </div>
            </form>
            
            <!-- PAST HERE THE REST OF THE FORMS -->
        </div>
    </div>

';
}
add_shortcode( 'bd-searchbox-one', 'search_box_one' );

?>
