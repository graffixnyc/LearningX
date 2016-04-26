var coverGuide = function(cover, target) {
    var body = document.body, doc = document.documentElement;
    var targetWidth = target.clientWidth,
        targetHeight = target.clientHeight;
    var pageWidth=doc.scrollWidth,
        pageHeight=doc.scrollHeight;

    // offset of target    
    var offsetTop = target.getBoundingClientRect().top
        offsetLeft = target.getBoundingClientRect().left
    // set size and border-width
    cover.style.left = offsetLeft + 'px';
    cover.style.top = offsetTop + 'px';
    cover.style.width = targetWidth + 'px';
    cover.style.height = targetHeight + 'px';    
    cover.style.borderWidth = 
        0 + 'px ' + 
        (pageWidth - targetWidth) + 'px ' +
        (pageHeight - targetHeight) + 'px ' + 
        0 + 'px';
    
    cover.style.display = 'block';

};

var elCover = document.getElementById('cover');
var arrElTarget = [
    document.getElementById('container'),
    document.getElementById('video'), 
    document.getElementById('menutext')
], index = 0;

coverGuide(elCover, arrElTarget[index]);

elCover.onclick = function() {
    index++;
    if (!arrElTarget[index]) {
        index = 0;    
    }
    coverGuide(elCover, arrElTarget[index]);
};
