---
layout: post
status: publish
comments: true
published: true
title: 'GoogleMaps: How to get InfoWindow in viewport'
date: '2012-12-05 18:57:39 +0100'
date_gmt: '2012-12-05 17:57:39 +0100'
categories:
- Uncategorized
tags:
- google
- google-maps
- javascript
---

Common request, when embedding Google Maps in your application, is to add a marker and a infoWindow that adds some text to the marker. It seems quite straightforward. Just create the map, add marker and add infoWindow with some content. Well it's not as simple as it looks. The map will probably be displayed in such manner, that the marker is in the middle and the infoWindow is hidden outside of the map. Grrr...

The fix is quite simple. You need to add timeout to <strong>opening the infoWindow</strong> or <strong>open it later on click event</strong> or something like that. There is unfortunately no <em>map init finished</em> event that you can hook onto, so timeout is the only solution to make the infoWindow appear without user interaction. See the following code:

```js
addMarker = function(map, location, title, text) {
    var marker, bounds, infowindow;
    marker = new google.maps.Marker({
        map: map,
        draggable: false,
        position: location,
        animation: google.maps.Animation.DROP,
        title: title
    });
    infowindow = new google.maps.InfoWindow({
        content: text
    });
    setTimeout(function(){
        infowindow.open(map, marker); 
    }, 2000);
};
```

The timeout is set to 2000ms, which is 2 seconds. That should be enough for the map to initialize. You need to find value that works for you by the method of trial&amp;error. 1500ms should work too, but I did fail with many maps on one page. There is also an option to hook it on <em>tilesloaded</em> event, but that assumes you won't let your users manipulate with the map, or else it would be called on any change to the map (zoom-in, pan, etc.).

I hope it helps ;)

