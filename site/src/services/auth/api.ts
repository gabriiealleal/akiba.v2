import axios from 'axios';
import { Credentials } from '@/services/auth/interfaces.ts';

export const Auth = async (credentials: Credentials) => {
    try {
        const response = await axios.post(`${import.meta.env.VITE_API_ADDRESS}/login`, credentials, {
            headers: {
                'Accept': 'application/json'
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

export const verifyAuth = async () => {
    try{
        const response = await axios.get(`${import.meta.env.VITE_API_ADDRESS}/verificarlogin`, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem('akb_token')}`,
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