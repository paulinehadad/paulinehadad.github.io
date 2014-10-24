    var feed = new Instafeed({
        get: 'tagged',
        tagName: 'nyc',
        clientId: '40fd8ee862024a5d86ccca9bdd9c36da',
        useHttp: true
    });
    feed.run();