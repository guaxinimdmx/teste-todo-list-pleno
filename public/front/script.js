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
      lists: {},
      activeListId: null,
      activeList: null,
      svg: {
        more: '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">' + '<path d="M20 14H14V20H10V14H4V10H10V4H14V10H20V14Z" />' + "</svg>",
        trash:
          '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">' +
          '<path d="M9,3V4H4V6H5V19A2,2 0 0,0 7,21H17A2,2 0 0,0 19,19V6H20V4H15V3H9M9,8H11V17H9V8M13,8H15V17H13V8Z" />' +
          "</svg>",
        check:
          '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">' +
          '<path d="M20,12A8,8 0 0,1 12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4C12.76,4 13.5,4.11 14.2,4.31L15.77,2.74C14.61,2.26 13.34,2 12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12M7.91,10.08L6.5,11.5L11,16L21,6L19.59,4.58L11,13.17L7.91,10.08Z"/>' +
          "</svg>",
        uncheck:
          '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">' +
          '<path d="M12,20A8,8 0 0,1 4,12A8,8 0 0,1 12,4A8,8 0 0,1 20,12A8,8 0 0,1 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z" />' +
          "</svg>",
      },
    };
  },
  methods: {
    renameTask(taskId) {
      const task = this.activeList.tasks.find((t) => t.id === taskId);
      if (!task) return;
      this.api("put", `tasks/${taskId}`, { description: task.description });
    },
    async toggleTask(taskId) {
      const task = this.activeList.tasks.find((t) => t.id === taskId);
      if (!task) return;
      task.is_done = !task.is_done;
      this.api("put", `tasks/${taskId}`, { is_done: task.is_done });
    },
    async createTask() {
      if (!this.activeListId) return;
      const n = this.activeList.tasks.length || 0;
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
    removeTask(taskId) {
      this.activeList.tasks = this.activeList.tasks.filter((l) => l.id !== taskId);
      this.api("delete", `tasks/${taskId}`);
    },

    updateLocalNameActiveList() {
      const list = this.lists.find((t) => t.id === this.activeListId);
      list.title = this.activeList.title;
    },
    renameActiveList() {
      const list = this.lists.find((t) => t.id === this.activeListId);
      this.api("put", `lists/${list.id}`, { title: list.title });
    },
    toggleActiveList(listId) {
      this.activeListId = listId == this.activeListId ? null : listId;
    },
    async loadActiveList() {
      if (!this.activeListId) {
        this.activeList = null;
      } else {
        const response = await this.api("get", `lists/${this.activeListId}`);
        if (response.error) {
          this.activeListId = null;
          return;
        }
        this.activeList = response.data;
      }
    },
    async createList() {
      const n = this.lists.length;
      const title = n === 0 ? "Nova lista" : `Nova lista ${n}`;
      const response = await this.api("post", `lists`, { title });
      if (!response.error) {
        this.lists.push(response.data);
        this.activeListId = response.data.id;
      }
    },
    removeList(listId) {
      if (this.activeListId == listId) this.activeListId = null;
      this.lists = this.lists.filter((l) => l.id !== listId);
      this.api("delete", `lists/${listId}`);
    },
    async loadDataLists() {
      const response = await this.api("get", "lists");
      if (response.error) return;
      this.lists = response.data;
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
    activeListId() {
      this.loadActiveList();
    },
  },
}).mount("#vue");
