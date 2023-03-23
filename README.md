#JTG Wordpress Theme
##Introduction
Documentaition of the Juedisch to Go Theme
##Map
###Options
Most of the Options of the Map can be adjusted in `customize->Karte`
* Marker Größe: This is the relativ size of the Markers found on the Leaflet Map. The Size is calculated as follows: `with = 27 * marker_size`, `heigt = 32 * marker_size`
* Steuerelement Größe: This is the relativ size of the Controll Elements
* Standort Kompassadel Größe: This is the relativ size of the location Indicator
* Städte (in JSON): Describes the Citys that can be selected and Jumped to via the City Selector on the Map. It needs to be formatted as following: `[{"address":"{address}", "title":"{title}"}, {...}]`. {address} can be just the Plain String of a Address or the String of an Array with Latitude as ist first and Longitude as its second element
###Function
