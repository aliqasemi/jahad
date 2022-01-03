import {
    getJson,
    getArray
} from "../resource/AttachmentResource";
import axios from "axios"

export default class AttachmentRepository {
    async indexAttachmentByRequirement(requirementId) {
        try {
            let response = await axios.get('http://127.0.0.1:8000/api/jahad/attach-requirement-service/' + requirementId);
            return getArray(response.data.data)
        } catch (e) {
            return e;
        }
    }

    async indexAttachmentByService(serviceId) {
        try {
            let response = await axios.get('http://127.0.0.1:8000/api/jahad/attach-service-requirement/' + serviceId);
            return getArray(response.data.data)
        } catch (e) {
            return e;
        }
    }
}
