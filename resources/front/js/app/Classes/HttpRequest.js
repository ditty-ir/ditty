export default class  HttpRequest {
    constructor(url = './', method = "get", data = {}, headers = {}) {
        this.url = url;
        this.method = method;
        this.data = data;
        this.headers = headers;
    }

    setUrl(url) {
        this.url = url;
    }

    setMethod(method) {
        this.method = (method.toLowerCase() == 'get' ? 'get' : 'post');
    }

    setData(data) {
        this.data = this.data;
    }

    setHeaders(headers) {
        this.headers = headers;

        return this;
    }

    send (resolve = undefined, reject = undefined) {
        $.ajax({
            url: this.url,
            data: this.data,
            method: this.method,
            headers: this.headers,
            error: (result) => {
                if (result.status == 404) {
                    window.Vue.$router.push({ name: '404'});
                } else {
                    return reject ? reject(result) : undefined;
                }
            },
            success: (result) => {
                return resolve ? resolve(result) : undefined;
            }
        });
    }
}
