/*
  Esse front-end está desacoplado da aplicação back-end.
  Foi colocado dentro da pasta /public/front apenas por conveniência de acesso.
  Ele consome a API via chamadas HTTP e não está integrado ao roteamento do CodeIgniter.
*/
const { createApp } = Vue;
createApp({
  data() {
    return {
      system: {
        step: "server",
        serverUrl: null,
        accessToken: null,
        formMessage: null,
        formLogin: { email: null, password: null },
        formServer: { url: "http://localhost:8080/api" },
      },
    };
  },
  methods: {
    goStep(step) {
      this.system.step = step;
    },
    useDefaultAcessLogin() {
      this.system.formLogin.email = "teste@teste.com";
      this.system.formLogin.password = "1234";
    },
    async login() {
      this.system.formMessage = null;
      const response = await this.api("post", "auth/login", this.system.formLogin);

      if (!response.error) {
        this.system.accessToken = response.data.token;
        localStorage.setItem("accessToken", this.system.accessToken);
        this.system.formLogin.email = null;
        this.system.formLogin.password = null;
      } else {
        this.system.formMessage = response.message;
      }
    },
    logout() {
      this.system.accessToken = null;
      localStorage.removeItem("accessToken");
    },
    useDefaultServerUrl() {
      this.system.formServer.url = "http://localhost:8080/api";
    },
    async loadUrlServer() {
      let url = sessionStorage.getItem("url_server") ?? this.system.formServer.url;
      if (!url.endsWith("/")) url += "/";

      this.system.serverUrl = url;

      const response = await this.api("get");

      if (!response.error) {
        this.system.step = "login";
        this.system.accessToken = localStorage.getItem("accessToken") ?? null;
      } else {
        this.system.serverUrl = null;
      }
    },
    async api(method, uri = "", data = null) {
      const options = { method: method.toUpperCase(), headers: { "Content-Type": "application/json" } };
      if (this.system.accessToken) options.headers.Authorization = `Bearer ${this.system.accessToken}`;
      if (data) options.body = JSON.stringify(data);

      let responseData = null;

      try {
        const response = await fetch(this.system.serverUrl + uri, options);
        responseData = await response.json();
      } catch {
        responseData = {
          error: true,
          status: 0,
          message: "Erro desconhecido",
          data: null,
        };
      }

      if (responseData.error && responseData.status === 401) this.system.step = "login";

      return responseData;
    },
  },
  mounted() {
    this.loadUrlServer();
  },
  watch: {
    "system.accessToken"(newVal) {
      this.system.step = Boolean(newVal) ? "app" : "login";
    },
  },
}).mount("#vue");
