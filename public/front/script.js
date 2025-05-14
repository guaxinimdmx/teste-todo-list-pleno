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
      activeListId: null,
      data: {
        lists: {},
        takes: {},
      },
    };
  },
  computed: {
    activeList() {
      if (!this.activeListId) return null;
      return this.data.lists.find((l) => l.id === this.activeListId) || null;
    },
  },
  methods: {
    async createTask() {
      if (!this.activeList) return;
      const n = this.data.tasks.length || 0;
      const description = n === 0 ? "Nova tarefa" : `Nova tarefa ${n}`;
      const response = await this.api("post", `lists/${this.activeListId}/tasks`, {
        list_id: this.activeListId,
        description,
      });
      if (!response.error) {
        if (!this.activeList.tasks) this.activeList.tasks = [];
        this.activeList.tasks.push(response.data);
      }
    },
    removeTask() {},
    async loadDataTasks() {
      const response = await this.api("get", `lists/${this.activeListId}`);
      if (response.error) return;
      this.data.tasks = response.data.tasks;
    },

    toggleActiveList(listId) {
      console.log("toggle", listId);
      this.activeListId = listId == this.activeListId ? null : listId;
    },
    async createList() {
      const n = this.data.lists.length;
      const title = n === 0 ? "Nova lista" : `Nova lista ${n}`;
      const response = await this.api("post", `lists`, { title });
      if (!response.error) {
        this.data.lists.push(response.data);
        this.activeListId = response.data.id;
      }
    },
    removeList(listId) {
      this.data.lists = this.data.lists.filter((l) => l.id !== listId);
      this.api("delete", `lists/${listId}`);
    },
    async loadDataLists() {
      const response = await this.api("get", "lists");
      if (response.error) return;
      this.data.lists = response.data;
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
    "system.step"(newVal) {
      if (newVal == "app") this.loadDataLists();
    },
    activeListId(newVal) {
      if (newVal && this.activeList) this.loadDataTasks();
    },
  },
}).mount("#vue");
