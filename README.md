
# Bath: Hacked WordPress Plugin

A WordPress plugin for displaying visualisations of data found in the 
Bath & North East Somerset [community datastore](https://data.bathhacked.org/) which is curated 
by the lovely people of [Bath: Hacked](https://www.bathhacked.org/).

## Status

This is a work in progress. Currently the plugin only displays data from a single dataset -
[BANES Live Car Park Occupancy](https://data.bathhacked.org/Transport/BANES-Live-Car-Park-Occupancy/u3w2-9yme).

Our intention is to add further datasets in the future.

## Disclaimer

Use this plugin at your own risk.

## Installation

- Download the repository ZIP file.
- Extract the ZIP contents somewhere.
- Rename the extracted folder to ```bath-hacked-plugin```.
- Upload the folder to your Wordpress plugin folder ```wp-content/plugins/```.
- Now activate the plugin in your WordPress dashboard.

## Configuration

At present, there is a single configuration option under ```"Settings > Bath: Hacked"```.

```"Car Park Dataset API URL"``` is initially populated with the current dataset within the Bath: Hacked datastore.
Should this dataset be moved, you will be able to change its URL here.

## Widgets

### Bath: Hacked Car Parks

Display either linear or radial gauges showing latest car park capacity. 
A check will be made for updates in capacity at 2 minute intervals & the gauges updated automatically.

#### Options

- ```Title```: Title to be displayed for widget. Leave blank to omit.
- ```Theme```: Use a ```dark``` or ```light``` theme for text colours.
- ```Style```: Use a ```linear``` or ```radial``` gauge style.

## Shortcodes

### Bath: Hacked Car Parks

Display either linear or radial gauges showing latest car park capacity. 
A check will be made for updates in capacity at 2 minute intervals & the gauges updated automatically.

```[bh_car_parks theme="dark" style="linear"]```

#### Options

- ```theme```: Use a ```dark``` or ```light``` theme for text colours.
- ```style```: Use a ```linear``` or ```radial``` gauge style.

## Bugs

Submit issues, or even better, pull requests.

## Credit

Feel free to remove the attribution from the plugin. Or feel free to leave it in to say thanks.

## Author

Mark Owen ([@azazell0](https://twitter.com/azazell0)).

## Copyright

Copyright (c) 2014 Mark Owen & Bath: Hacked

## Data License

Please consult individual datasets at [Bath: Hacked](https://www.bathhacked.org/) for their licensing information.

Your right to use this software does not necessarily confer any right to use the data provided by 
Bath: Hacked or Bath & North East Somerset Council.

## Plugin License

	The MIT License (MIT)

	Copyright (c) 2014 

	Permission is hereby granted, free of charge, to any person obtaining a copy
	of this software and associated documentation files (the "Software"), to deal
	in the Software without restriction, including without limitation the rights
	to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
	copies of the Software, and to permit persons to whom the Software is
	furnished to do so, subject to the following conditions:

	The above copyright notice and this permission notice shall be included in all
	copies or substantial portions of the Software.

	THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
	IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
	FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
	AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
	LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
	OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
	SOFTWARE.

