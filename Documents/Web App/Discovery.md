**V 1.0.1**
# Web App Discovery
The web app will be used to display data from the API to a human user. It will be a javascript based application that will run on mobiles, tablets and desktops. 

## Interface
Several ideas of displaying and using the data have been played with. These include:  

* Flat table of times
* Intergrating into a SatNav
* Map with gate icons
* Email to bus drivers every morning

In the end we decided to go with the map as it displays all the data for the country in a easy to access and understand manner. However, we also wanted to display predicted future data so we decided to include the flat table of times for the future in a popup, or overlay it when a user selects a crossing. 

## Technologies

### JS Framework - AnuglarJs vs EmberJs
The app will be built in javascript. Rather then using Vanilla JS a framework will be used. After some research we discovered that the two current most popular JavaScript frameworks are AngularJS and EmberJS.  The table bellow shows the general community level of support for each and angular is the clear winner. Building the product on something that the community is behind is a big positive because it often leads to a more stable product, with more libaries meaning less bugs and development time overall.


| Metric | AngularJS | EmberJS |
| ------ | --------- | ------- |
| Stars on Github | 40.2k | 14.1k |
| Third-Party Modules | 1488 | 1155 |
| StackOverflow Questions | 104k | 15.7k |
| YouTube Results | ~93k | ~9.1k |
| GitHub Contributors | 96 | 501 |
| Chrome Extension Users | 275k | 66k |


### CSS Compiler - LESS vs SCSS
All web sites require styling using css but using a compiler normally leads to more readible and overall less code. The two most commonly used are LESS and SCSS. LESS has been the bigger compitior for many years with large projects like Bootstrap using it. More recently SCSS has started to take the lead with large projects moving over because of its likness to native CSS and overall lower learning curve. Its primarly this reason i'll be choosing SCSS for this project.