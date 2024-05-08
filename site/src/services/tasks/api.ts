import axios from 'axios';
import { getTasksTypes } from '@/services/tasks/interfaces.ts';

export const getTasks = async (queryParams: getTasksTypes) => {
    try{
        const response = await axios.get(`${import.meta.env.VITE_API_ADDRESS}/tarefas`, {
            params: {
                user: queryParams.user
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

export const updateTaks = async (queryParams: getTasksTypes, data: any) => {
    console.log(data)
    try{
        const response = await axios.patch(`${import.meta.env.VITE_API_ADDRESS}/tarefas/${queryParams.id}`, data, {
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