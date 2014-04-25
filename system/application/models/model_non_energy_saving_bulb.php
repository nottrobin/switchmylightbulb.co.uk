<?php

/**
 * Model containing energy saving bulbs
 */
class Model_non_energy_saving_bulb extends DataMapper {

    var $table = 'non_energy_saving_bulb';

    var $has_many = array(
        'energy_saving_bulb' => array('class' => 'model_energy_saving_bulb', 'other_field' => 'non_energy_saving_bulb')
    );
}

/* End of file model_energy_saving_bulb.php */
/* Location: ./application/models/model_energy_saving_bulb.php */
