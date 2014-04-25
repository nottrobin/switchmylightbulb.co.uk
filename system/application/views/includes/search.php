
      <section id="search"> 
        <form action="/bulbs/search" method="post">
          <input placeholder="search for bulbs" type="search" name="search" id="field_search" />
          <select name="field">
            <option value="all_fields">all fields</option>
            <option value="name">name</option>
            <option value="wattage">wattage</option>
            <option value="voltage">voltage</option>
            <option value="fitting_cap">fitting cap</option>
            <option value="length_mm">length (mm)</option>
            <option value="diameter">diameter</option>
            <option value="rated_life">rated life</option>
            <option value="energy_rating">energy rating</option>
            <option value="lumen_out">lumen out</option>
            <option value="to_be_banned">to be banned</option>
            <option value="colour_temp">colour temperature</option>
            <option value="dimmable">is dimmable</option>
            <option value="typical_price">typical price</option>
            <option value="beam_angle">beam angle</option>
            <option value="intensity">intensity</option>
            <option value="no_leds">no leds</option>
            <option value="equivalent-to">equivalent to</option>
          </select>
          <button type="submit"><img src="/images/go-submit.png" /></button>
        </form>
      </section>
