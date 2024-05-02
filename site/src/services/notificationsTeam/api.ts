import axios from "axios";

//Importando interfaces
import { NotificationParams } from '@/services/notificationsTeam/interfaces.ts';

export const getNotificationsTeam = async (queryParams: NotificationParams) => {
    try{
        const response = await axios.get(`${import.meta.env.VITE_API_ADDRESS}/notificacoes`, {
            params: {
                user: queryParams,
            },
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