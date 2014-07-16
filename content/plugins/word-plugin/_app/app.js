require.config({
    baseUrl: wordsearchGameCreator.baseUrl
});
document.createElement("wordsearch");
require(["main"], function(Soup){
    Soup.points = {
        ON_FOUND: 10,
        ON_HINT: -10
    };

    var wordsearchs = _.toArray(document.getElementsByTagName("wordsearch")),
        wordsearch, i, l;

    for (i = 0, l = wordsearchs.length; i < l; i++) {

    var soup = new Soup({
        container: wordsearchs[i],
        totalWords: 10,
        size: 20, // 15x15
        initialScore: 1000,
        every: 3, // 10 seconds
        deduct: 2,
        showForm: true,
        maxTime: 30,
        wordDirections: ['horizontal']
    });
}
});
