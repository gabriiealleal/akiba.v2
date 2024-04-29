//Importando componentes da view
import BoasVindas from '@/interfaces/private/components/dashboard/BoasVindas';
import AvisosParaEquipe from '../../components/dashboard/AvisosParaEquipe';

const Dashboard = () => {
    return (
        <>
            <BoasVindas/>
            <AvisosParaEquipe/>
        </>
    );
}

export default Dashboard;