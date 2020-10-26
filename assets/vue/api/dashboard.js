import axios from "axios";

export default {
  create(message) {
    return axios.post("/api/dashboard", {
      message: message
    });
  },
  findAllHotel() {
    return axios.get("/api/dashboard");
  }
};