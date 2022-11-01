import axios from "axios";

export const request = async (method, url, data) => {
    const token = localStorage.getItem('APP_DEMO_USER_TOKEN')
    if (token !== undefined || token !== "") {
        const headers = {
            headers: {
                Authorization: 'Bearer ' + token
            }
        }
        let response = null;
        switch (method) {
            case 'get':
                response = await axios.get(url, headers)
                break;
            case 'post':
                response = await axios.post(url, data, headers)
                break;
            case 'put':
                response = await axios.put(url, data, headers)
                break;
            case 'delete':
                response = await axios.delete(url, headers)
                break;
            default:
                break;
        }
        return response
    }
    return false
}
