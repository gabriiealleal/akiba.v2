import axios from 'axios';

export const getPosts = async () => {
    try{
        const response = await axios.get(`${import.meta.env.VITE_API_ADDRESS}/postagens`, {
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${localStorage.getItem('akb_token')}`,
            }
        });
        return response.data;
    }catch(error: any){
        throw error;
    }
}