import axios from 'axios';

interface Credentials {
    login: string;
    password: string;
}

export const auth = async (credentials: Credentials) => {
    try {
        const response = await axios.post(`${import.meta.env.VITE_API_ADDRESS}/login`, credentials, {
            headers: {
                Accept: 'application/json'
            }
        });

        if (response.status !== 200) {
            throw new Error('Falha na autenticação');
        }

        return response.data;
    } catch (error) {
        throw error;
    }
}

export const verifyAuth = async (token: string) => {
    try{
        const response = await axios.get(`${import.meta.env.VITE_API_ADDRESS}/verificarlogin`, {
            headers: {
                Authorization: `Bearer ${token}`,
                Accept :'application/json', 
            }
        });

        if(response.status !== 200){
            throw new Error('Falha na autenticação');
        }

        return response.data;
    }catch(error){
        console.log(error)
        throw error;
    }
}